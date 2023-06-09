<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StoreBookingRequest;
use App\Http\Requests\V1\workSpace\UpdateBookingRequest;
use App\Http\Resources\V1\workSpace\BookingResource;
use App\Models\Booking;
use App\Models\DayOff;
use App\Models\OpeningHour;
use App\Models\Plan;
use App\Traits\Utilities;


use Illuminate\Http\Request;

class BookingController extends Controller
{

    use Utilities;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query =Booking::query()
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
                'workspace' => function ($query) {
                    $query->select('id', 'name');
                }
            ]);

        if ($request->has('numberOfPersons')) {
            $query->where('number_of_persons',  $request->numberOfPersons);
        }
        if ($request->has('startDate')) {
            $query->where('start_date', 'LIKE', '%' . $request->startDate . '%');
        }
        if ($request->has('endDate')) {
            $query->where('end_date', 'LIKE', '%' . $request->endDate . '%');
        }
        if ($request->has('startTime')) {
            $query->where('start_time', 'LIKE', '%' . $request->startTime . '%');
        }
        if ($request->has('paymentStatus')) {
            $query->where('payment_status', $request->paymentStatus);
        }
        if ($request->has('totalPrice')) {
            $query->where('totalPrice', $request->totalPrice);
        }
        if ($request->has('endTime')) {
            $query->where('end_time', 'LIKE', '%' . $request->endTime . '%');
        }
        // Filter by birth date if requested
        if ($request->has('name')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', $request->name);
            });
        }
        if ($request->has('userId')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->userId);
            });
        }

        // Get the results and format them as an array of rendezvous data
        if ($request->has("forAdmin")) {
            $bookings = $query->get()->map(function ($booking) {
                $user = $booking->user ? $booking->user :null;
                $workSpace = $booking->workspace ?$booking->workspace :null;
                return [
                    'id' => $booking->id,
                    'workSpace' =>$workSpace? $workSpace->name :null,
                    'name' =>$user? $user->name :null,
                    'numberOfPersons' => $booking->number_of_persons,
                    'paymentStatus' => $booking->payment_status,
                    'totalPrice' => $booking->total_price,
                    'startDate' => $booking->start_date,
                    'endDate' => $booking->end_date,
                    'startTime' => $booking->end_date,
                    'endTime' => $booking->end_date,


                ];
            });
        } else {
            $bookings = $query->get()->map(function ($booking) {
                $workSpace = $booking->workspace ?$booking->workspace :null;
                return [
                    'id' => $booking->id,
                    'workSpace' =>$workSpace? $workSpace->name :null,
                    'numberOfPersons' => $booking->number_of_persons,
                    'paymentStatus' => $booking->payment_status,
                    'totalPrice' => $booking->total_price,
                    'startDate' => $booking->start_date,
                    'endDate' => $booking->end_date,
                    'startTime' => $booking->end_date,
                    'endTime' => $booking->end_date,
                ];
            });
        }


        return response()->json([
            'status' => 'success',
            'bookings' => $bookings
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des Bookings",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StoreBookingRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $workspaceId = $validatedData['workspace_id'];
            $planId = $validatedData['plan_id'];
            $numberOfPersons = $validatedData['number_of_persons'];
            $startDate = $validatedData['start_date'];
            $endDate = $validatedData['end_date'];
            $startTime = $validatedData['start_time'];
            $endTime = $validatedData['end_time'];

            $plan = Plan::where('id', $planId)
                ->where('capacity', '>=', $numberOfPersons)
                ->where([
                    ['start_date', '<=', $startDate],
                    ['end_date', '>=', $endDate],
                ])->first();

            if (!$plan) {
                throw new \Exception("La période que vous recherchez ne correspond pas au planning de l'espace de travail actuel. Essayez un autre planning ou un autre espace de travail .");
            }

            $daysOffs = DayOff::where('workspace_id', $workspaceId)
                ->where('days_off_start', '>=', $startDate)
                ->get();

            if ($daysOffs->isNotEmpty()) {
                $daysOffDetails = $daysOffs->map(function ($daysOff) {
                    return " du " . $daysOff->days_off_start . " au " . $daysOff->days_off_end;
                })->implode(",\n");
                throw new \Exception("L'espace de travail sera en vacances durant la période choisie.\nLes dates:\n$daysOffDetails");
            }

            $openingHours = OpeningHour::where('workspace_id', $workspaceId)->get();

            if ($startTime && $endTime) {
                $isOpeningHourFound = $openingHours->contains(function ($openingHour) use ($startTime, $endTime) {
                    return $openingHour->open_time <= $startTime && $openingHour->close_time >= $endTime;
                });

                if (!$isOpeningHourFound) {
                    throw new \Exception("Nous n'avons pas trouvé de planning correspondant aux horaires que vous avez sélectionnés.");
                }

                $totalHours = 0;
                foreach ($openingHours as $openingHour) {
                    $totalHours += $this->calculateTotalHours($startTime, $endTime);
                }
            } else {
                $totalHours = 0;
                foreach ($openingHours as $openingHour) {
                    $totalHours += $this->calculateTotalHours($openingHour->open_time, $openingHour->close_time);
                }
            }

            $workingDays = $openingHours->pluck('day_of_week')->toArray();
            $totalDays = $this->getTotalDays($startDate, $endDate, $workingDays);
            $totalPrice = $totalHours * $totalDays * $numberOfPersons * $plan->workspace->price_per_hour;
            $validatedData['total_price'] = $totalPrice;
            $booking = Booking::create($validatedData);
            $plan->decrement('capacity', $numberOfPersons);
            return response()->json([
                'message' => 'Booking created successfully',
                'booking' => new BookingResource($booking)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création de la réservation",
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(String $lang, Booking $booking)
    {
        try {
            $booking->loadMissing('user');
            $booking->loadMissing('workspace');
            $booking->loadMissing('plan');
            return response()->json([
                'message' => 'Booking retrieved successfully',
                'booking' => new BookingResource($booking)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du Booking",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdateBookingRequest $request, Booking $booking)
    {
        try {
            // $booking["state"] = "read";
            $booking->loadMissing('user');
            $booking->loadMissing('workspace');
            $booking->loadMissing('plan');
            return response()->json([
                'message' => 'Booking updated successfully',
                'booking' => new BookingResource($booking)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création de la Booking",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, Booking $booking)
    {
        try {
            // Find the plan associated with the booking
            $plan = $booking->plan;

            // Increment the capacity by the number of persons in the booking
            $plan->capacity += $booking->number_of_persons;

            // Save the updated plan
            $plan->save();
            // Delete the booking
            $booking->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du Booking",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Booking deleted successfully',
        ], 200);
    }

}
