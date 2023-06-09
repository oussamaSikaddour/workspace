<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\GeneralSettingsController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["prefix" => "v1/{locale}", "namespace" => "App\Http\Controllers\V1", "middleware" => ["auth:sanctum", "setAppLang"]], function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource("roles", RoleController::class);
    Route::apiResource("gSettings", GeneralSettingsController::class);
    Route::apiResource("workspaces", WorkSpaceController::class);
    Route::apiResource("openingHours",OpeningHourController::class);
    Route::apiResource("plans",PlanController::class);
    Route::apiResource("products",ProductController::class);
    Route::apiResource("bookings",BookingController::class);
    Route::apiResource('daysOff', DayOffController::class)->parameters(['daysOff' => 'dayOff']);
    Route::apiResource("messages", MessageController::class);
    Route::apiResource("notifications", NotificationController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('manageRoles', [RoleController::class, 'manageRoles']);
    Route::get('createBackup', [GeneralSettingsController::class, 'createBackup']);
    Route::patch('changePassword/{user}', [AuthController::class, 'changePassword']);
});

Route::group(["prefix" => "v1/{locale}", "namespace" => "App\Http\Controllers\V1", "middleware" => ["setAppLang"]], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::get("productsForUser", [ProductController::class, "getProductsForUser"]);
    Route::apiResource("userMessages", UserMessageController::class);
    Route::post('login', [AuthController::class, 'login']);
    Route::post("forgotPassword", [AuthController::class, "forgotPassword"]);
    Route::post("forgotPassword", [AuthController::class, "forgotPassword"]);
    Route::get("reSendVerificationEmail/{user}", [AuthController::class, "reSendEmailVerification"]);
    Route::post("emailVerification", [AuthController::class, "emailVerification"]);
});
