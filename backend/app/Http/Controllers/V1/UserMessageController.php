<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\workSpace\StoreUserMessageRequest;
use App\Http\Resources\V1\workSpace\UserMessageResource;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class UserMessageController extends Controller
{    public function index(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $query =UserMessage::query();

            if ($request->query('name')) {
                $name = $request->input("name");
                $query->where('name','like','%'.$name.'%');
            }
            if ($request->query('email')) {
                $email = $request->input("email");
                $query->where('email','like','%'.$email.'%');
            }
            if ($request->query('tel')) {
                $tel = $request->input("tel");
                $query->where('tel','like','%'.$tel.'%');
            }


            if ($request->query("includeAll")) {
                $messages = $query->get();
                $messages=UserMessageResource::collection($messages);
            } else {

                $messages = $query->get()->map(function ($userMessage) {

                    return [
                        'id' => $userMessage->id,
                        'name' => $userMessage->name,
                        'email' => $userMessage->email,
                        'tel' => $userMessage->tel,
                        "createdAt"=> $userMessage->created_at
                    ];
                });

            }




            // Get the results and format them as an array of rendezvous data


            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des messages",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StoreUserMessageRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $userMessage =UserMessage::create($validatedData);

            return response()->json([
                'message' => 'UserMessage created successfully',
                'userMessage' => new UserMessageResource($userMessage)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création du message",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang,UserMessage $userMessage)
    {
        try {
            return response()->json([
                'message' => 'UserMessage retrieved successfully',
                'userMessage' => new UserMessageResource($userMessage)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du message",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, Request $request,UserMessage $userMessage)
    {
        try {
            // $userMessage["state"] = "read";
           $data = $request->validated();
            $userMessage->update($data);
            return response()->json([
                'message' => 'UserMessage updated successfully',
                'userMessage' => new UserMessageResource($userMessage)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la modification du message",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang,UserMessage $userMessage)
    {
        try {
            $userMessage->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression duUserMessage",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'UserMessage deleted successfully',
        ], 200);
    }
}
