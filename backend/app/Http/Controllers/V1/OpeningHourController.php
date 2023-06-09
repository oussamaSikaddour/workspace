<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StoreOpeningHourRequest;
use App\Http\Requests\V1\workSpace\UpdateOpeningHourRequest;
use App\Http\Resources\V1\workSpace\OpeningHourResource;
use App\Models\OpeningHour;
use Illuminate\Http\Request;

class OpeningHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $query = OpeningHour::query();
            if ($request->query('workSpace')) {
                $workSpaceId = $request->input("workSpace");
                $query->where('workspace_id',$workSpaceId);
            }
            if ($request->query('dayOfWeek')) {
                $dayOfWeek = $request->input("dayOfWeek");
                $query->where('day_of_week',$dayOfWeek);
            }
            if ($request->query('openTime')) {
                $openTime = $request->input("openTime");
                $query->where('open_time',$openTime);
            }
            if ($request->query('closeTime')) {
                $closeTime = $request->input("closeTime");
                $query->where('close_time',$closeTime);
            }


            if ($request->query("includeAll")) {
                $openingHours = $query->get();
                $openingHours= OpeningHourResource::collection($openingHours);
            } else {

                $openingHours = $query->get()->map(function ($openingHour) {

                    return [
                        'id' => $openingHour->id,
                        'dayOfWeek'=> $openingHour->day_of_week,
                        'openTime'=> $openingHour->open_time,
                        'closeTime'=> $openingHour->close_time,
                    ];
                });

            }




            // Get the results and format them as an array of rendezvous data


            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'openingHours' => $openingHours
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des jours de congés",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StoreOpeningHourRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $openingHour = OpeningHour::create($validatedData);

            return response()->json([
                'message' => 'OpeningHour created successfully',
                'openingHour' => new OpeningHourResource($openingHour)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création de le OpeningHour",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, OpeningHour $openingHour)
    {
        try {
            $openingHour->loadMissing('workspace');
            return response()->json([
                'message' => 'OpeningHour retrieved successfully',
                'openingHour' => new OpeningHourResource($openingHour)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du OpeningHour",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdateOpeningHourRequest $request, OpeningHour $openingHour)
    {
        try {
            // $openingHour["state"] = "read";
           $data = $request->validated();
           $openingHour->update($data);
            return response()->json([
                'message' => 'OpeningHour updated successfully',
                'openingHour' => new OpeningHourResource($openingHour)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création de la OpeningHour",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, OpeningHour $openingHour)
    {
        try {
            $openingHour->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du OpeningHour",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'OpeningHour deleted successfully',
        ], 200);
    }
}
