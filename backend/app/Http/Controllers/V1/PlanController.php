<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StorePlanRequest;
use App\Http\Requests\V1\workSpace\UpdatePlanRequest;
use App\Http\Resources\V1\workSpace\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $query = Plan::query();
            if ($request->query('workSpace')) {
                $workSpaceId = $request->input("workSpace");
                $query->where('workspace_id',$workSpaceId);
            }
            if ($request->query('capacity')) {
                $capacity = $request->input("capacity");
                $query->where('capacity',$capacity);
            }
            if ($request->query('startDate')) {
                $startDate = $request->input("startDate");
                $query->where('start_date', '<=', $startDate);
            }
            if ($request->query('endDate')) {
                $endDate = $request->input("endDate");
                $query->where('end_date', '>=', $endDate);
            }
            if ($request->query('status')) {
                $status = $request->input("status");
                $query->where('status',$status);
            }


            if ($request->query("includeAll")) {
                $plans = $query->get();
                $plans= PlanResource::collection($plans);
            } else {

                $plans = $query->get()->map(function ($plan) {

                    return [
                        'id' => $plan->id,
                        'capacity'=> $plan->capacity,
                        'startDate'=> $plan->start_date,
                        'endDate'=> $plan->end_date,
                        'status'=>$plan->status
                    ];
                });

            }




            // Get the results and format them as an array of rendezvous data


            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'plans' => $plans
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des plannings",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StorePlanRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $plan = Plan::create($validatedData);

            return response()->json([
                'message' => 'Plan created successfully',
               'plan' => new PlanResource($plan)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création de le Plan",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, Plan $plan)
    {
        try {
            $plan->loadMissing('workspace');
            $plan->loadMissing('bookings');
            return response()->json([
                'message' => 'Plan retrieved successfully',
               'plan' => new PlanResource($plan)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du Plan",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdatePlanRequest $request, Plan $plan)
    {
        try {
            $data = $request->validated();
            $plan->update($data);
            return response()->json([
                'message' => 'Plan updated successfully',
               'plan' => new PlanResource($plan)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création de la Plan",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, Plan $plan)
    {
        try {
            $plan->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du Plan",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Plan deleted successfully',
        ], 200);
    }
}
