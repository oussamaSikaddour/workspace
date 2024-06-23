<?php

use App\Enums\RoutesNamesEnum;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\RoutesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth','maintenance']], function () {
    Route::get('/noAccess', [AuthController::class, 'noAccessPage'])->name('noAccess');
    Route::get('/changePassword', [AuthController::class, 'changePasswordPage'])->name('changePassword');
    Route::get('/changeEmail', [AuthController::class, 'changeEmailPage'])->name('changeEmail');
    Route::get('/home', [RoutesController::class, 'showUserPage'])->name(RoutesNamesEnum::USER_ROUTE);
    Route::get('/profile', [RoutesController::class, 'showProfilePage'])->name(RoutesNamesEnum::PROFILE_ROUTE);
    // Establishment Route with optional 'id' parameter
    Route::middleware('can:admin-access')->group(function () {
        Route::get('/dashboard', [RoutesController::class, 'showAdminPage'])->name(RoutesNamesEnum::ADMIN_ROUTE);
        Route::get('/messages', [RoutesController::class, 'showMessagesPage'])->name('messages');
        Route::get('/manageUsers', [RoutesController::class, 'showUsersPage'])->name("users");
        Route::get('/manageProducts', [RoutesController::class, 'showProductsPage'])->name("products");
        Route::get('/manageClassRooms', [RoutesController::class, 'showClassRoomsPage'])->name("classrooms");
        Route::get('/manageTrainings', [RoutesController::class, 'showTrainingsPage'])->name("trainings");
     Route::get('/classrooms/{classroomId?}/dayOff', [RoutesController::class, 'showDayoffPage'])->name('dayoff');
     Route::get('/manageLanding', [RoutesController::class, 'showManageLandingPage'])->name('manageLanding');
     Route::get('/manageHero', [RoutesController::class, 'showManageHeroPage'])->name('manageHero');
     Route::get('/manageAboutUs', [RoutesController::class, 'showManageAboutUsPage'])->name('manageAboutUs');
     Route::get('/manageSocials', [RoutesController::class, 'showManageSocialsPage'])->name('manageSocials');
    });


});
