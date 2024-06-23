<?php


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
Route::get('lang/{lang}',function($lang){
    app()->setLocale($lang);
    session()->put('locale',$lang);
    return redirect()->back();
    })->name('setLang');
Route::get('/siteParameters', [RoutesController::class, 'showSiteParametersPage'])->name('siteParameters');
Route::get('/maintenanceMode', [AuthController::class, 'maintenanceModePage'])->name('maintenanceMode');



Route::group(['middleware'=>'maintenance'],  function(){
    Route::get('/',[AuthController::class, 'index'])->name('homePage');
    Route::get('/products/{productId?}', [RoutesController::class, 'showProductPage'])->name('product');
    Route::get('/classrooms/{classroomId?}', [RoutesController::class, 'showClassroomPage'])->name('classroom');
    Route::get('/classroomsPages', [RoutesController::class, 'showClassroomsPagesPage'])->name('classroomsPages');
    Route::get('/trainingsPages', [RoutesController::class, 'showTrainingsPagesPage'])->name('trainingsPages');
    Route::get('/productsPages', [RoutesController::class, 'showProductsPagesPage'])->name('productsPages');
    Route::get('/trainings/{trainingId?}', [RoutesController::class, 'showTrainingPage'])->name('training');
});


Route::group(['middleware'=>['guest','maintenance']],  function(){
    Route::get('/register',[AuthController::class, 'showRegisterPage'])->name('registerPage');
    Route::get('/login',[AuthController::class, 'showLoginPage'])->name('loginPage');
    Route::get('/forgetPassword',[AuthController::class, 'showForgetPasswordPage'])->name('forgetPasswordPage');

});



