<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Dsp\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $notifications = Notification::where('active', true)
                ->get()
                ->map(function ($notification) {
                    return new NotificationResource($notification);
                });
            return response()->json([
                'message' => 'Notifications retrieved successfully',
                'notifications' => $notifications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération des notifications",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, Notification $notification)
    {
        try {
            $notification->loadMissing('document');
            return response()->json([
                'message' => 'Notification retrieved successfully',
                'Notification' => new NotificationResource($notification)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération de la Notification",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, Request $request, Notification $notification)
    {
        try {
            $notification["active"] = false;
            $notification->update();
            return response()->json([
                'message' => 'Notification updated successfully',
                'Notification' => new NotificationResource($notification)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la modification de la Notification",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $lang, Notification $notification)
    {
        try {
            $notification->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de la suppression du Notification",
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Notification deleted successfully',
        ], 200);
    }
}
