<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreMessageRequest;
use App\Http\Resources\V1\Dsp\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $userId = $request->input("userId", null);

            if ($request->query('updateMessages')) {
                Message::where('user_id', $userId)
                    ->where('state', "unread")
                    ->update(['state' =>"read"]);
            }
            $messages = Message::when($userId, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
                ->get()
                ->map(function ($message) {
                    return new MessageResource($message);
                });
            return response()->json([
                'message' => 'Messages retrieved successfully',
                'messages' => $messages
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des messages",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(String $lang, StoreMessageRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $message = Message::create($validatedData);

            return response()->json([
                'message' => 'Message created successfully',
                'Message' => new MessageResource($message)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la création de le Message",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, Message $message)
    {
        try {
            $message->loadMissing('user');
            return response()->json([
                'message' => 'Message retrieved successfully',
                'Message' => new MessageResource($message)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du Message",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, Request $request, Message $message)
    {
        try {
            $message["state"] = "read";

            return response()->json([
                'message' => 'Message updated successfully',
                'Message' => new MessageResource($message)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la création de la Message",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, Message $message)
    {
        try {
            $message->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du Message",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Message deleted successfully',
        ], 200);
    }
}
