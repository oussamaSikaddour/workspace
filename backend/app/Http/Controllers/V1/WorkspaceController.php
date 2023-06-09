<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StoreWorkspaceRequest;
use App\Http\Requests\V1\workSpace\UpdateWorkspaceRequest;
use App\Http\Resources\V1\workSpace\WorkSpaceResource;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

        {
            try {
                // Define the base query with eager loading of related models
                $query = Workspace::query()->with(['plans','openingHours']);
                if ($request->query('name')) {
                    $name = $request->input("name");
                    $query->where('name','like','%'.$name .'%');
                }
                if ($request->query('location')) {
                    $location = $request->input("location");
                    $query->where('location','like','%'.$location.'%');
                }

                if ($request->has('capacity')) {
                    $capacity = $request->input("capacity");
                    $query->where('capacity','like','%'.$capacity.'%');
                }


                if ($request->has('pricePerHour')) {
                    $pricePerHour = $request->input("pricePerHour");
                    $query->where('price_per_hour','like','%'.$pricePerHour.'%');
                }



                if ($request->query("includeAll")) {
                    $workSpaces = $query->get();
                    $workSpaces = WorkSpaceResource::collection($workSpaces);
                } else {

                    $workSpaces = $query->get()->map(function ($workSpace) {

                        return [
                            'id' => $workSpace->id,
                            'name' => $workSpace->name,
                            'location' => $workSpace->location,
                            'capacity' => $workSpace->capacity,
                            'pricePerHour' => $workSpace->price_per_hour,
                        ];
                    });

                }




                // Get the results and format them as an array of rendezvous data


                // Return the formatted data as a JSON response
                return response()->json([
                    'status' => 'success',
                    'workSpaces' => $workSpaces
                ]);
            } catch (\Exception $e) {
                // Handle any exceptions and return an error response
                return response()->json([
                    'message' => "Une erreur s'est produite lors de la récupération des espaces de travails",
                    'error' => $e->getMessage()
                ], 500);
            }
        }




    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StoreWorkspaceRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $workspace = Workspace::create($validatedData);

            return response()->json([
                'message' => 'Workspace created successfully',
                'workSpace' => new WorkspaceResource($workspace)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création de le Workspace",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, Workspace $workspace)
    {
        try {
            // $workspace->loadMissing('plans');
            // $workspace->loadMissing('bookings');
            // $workspace->loadMissing('daysOff');
            // $workspace->loadMissing('openingHours');
            return response()->json([
                'message' => 'Workspace retrieved successfully',
                'workSpace' => new WorkSpaceResource($workspace)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du Workspace",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        try {
            // $workspace["state"] = "read";

            $data = $request->validated();
            $workspace->update($data);
            return response()->json([
                'message' => 'Workspace updated successfully',
                'workSpace' => new WorkspaceResource($workspace)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création de la Workspace",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, Workspace $workspace)
    {
        try {
            $workspace->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du Workspace",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Workspace deleted successfully',
        ], 200);
    }
}
