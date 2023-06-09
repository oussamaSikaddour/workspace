<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StoreDayOffRequest;
use App\Http\Requests\V1\workSpace\UpdateDayOffRequest;
use App\Http\Resources\V1\workSpace\DayOffResource;
use App\Models\DayOff;
use Illuminate\Http\Request;

class DayOffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $query = DayOff::query();
            if ($request->query('workSpace')) {
                $workSpaceId = $request->input("workSpace");
                $query->where('workspace_id',$workSpaceId);
            }
            if ($request->query('daysOffStart')) {
                $daysOffStart = $request->input("daysOffStart");
                $query->where('days_off_start','like','%'.$daysOffStart.'%');
            }
            if ($request->query('daysOffEnd')) {
                $daysOffEnd = $request->input("daysOffEnd");
                $query->where('days_off_end','like','%'.$daysOffEnd.'%');
            }


            if ($request->query("includeAll")) {
                $daysOff = $query->get();
                $daysOff= DayOffResource::collection($daysOff);
            } else {

                $daysOff = $query->get()->map(function ($dayOff) {

                    return [
                        'id' => $dayOff->id,
                        'daysOffStart'=> $dayOff->days_off_start,
                        'daysOffEnd'=> $dayOff->days_off_end,
                    ];
                });

            }




            // Get the results and format them as an array of rendezvous data


            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'daysOff' => $daysOff
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
    public function store(String $lang, StoreDayOffRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $dayOff = DayOff::create($validatedData);

            return response()->json([
                'message' => 'DayOff created successfully',
                'dayOff' => new DayOffResource($dayOff)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création de le DayOff",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, DayOff $dayOff)
    {
        try {
            $dayOff->loadMissing('workspace');
            return response()->json([
                'message' => 'DayOff retrieved successfully',
                'dayOff' => new DayOffResource($dayOff)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du DayOff",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdateDayOffRequest $request, DayOff $dayOff)
    {
        try {
            // $dayOff["state"] = "read";
           $data = $request->validated();
            $dayOff->update($data);
            return response()->json([
                'message' => 'DayOff updated successfully',
                'dayOff' => new DayOffResource($dayOff)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création de la DayOff",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, DayOff $dayOff)
    {
        try {
            $dayOff->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du DayOff",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'DayOff deleted successfully',
        ], 200);
    }
}
