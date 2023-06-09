<?php

namespace App\Traits;

use App\Models\User;

trait HttpManagements
{

    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => 'Request was successful.',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($data, string $message = null, int $code)
    {
        return response()->json([
            'status' => 'An error has occurred...',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function checkTokenAbility(User $user, array $abilitiesToCheck)
    {
        $token = $user->tokens()->first();
        $abilities = $token->abilities;

        foreach ($abilitiesToCheck as $ability) {
            if (!in_array($ability, $abilities)) {
                return false;
            }
        }

        return true;
    }
}
