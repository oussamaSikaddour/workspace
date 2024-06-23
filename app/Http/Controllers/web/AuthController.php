<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Hero;
use App\Models\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
 public function index ($sectionId="hero"):View{

    $title =__("pages.landing.page-title");


    $gSettings=GeneralSetting::first();
    $hero = Hero::first();
    $slides=[];

    $images = Image::where('imageable_id', $hero->id)
    ->where('imageable_type','App\Models\Hero')
    ->where('use_case','hero')->get();
    foreach($images as $image){
     $slides[]=
        [
            'image' => $image->url,
            'title' => '',
            'caption' => ''
        ];
    }

    return view('pages.welcome',compact('title' ,'slides','gSettings'));
 }
 public function noAccessPage():View{
    $title =__("pages.no-access.page-title");
    return view('pages.noAccess',compact('title'));
 }
 public function maintenanceModePage():View{
    $title =__("pages.maintenance-mode.page-title");
    return view('pages.maintenance-mode',compact('title'));
 }
 public function showLoginPage():View{
    $title =__("pages.login.page-title");
    return view('pages.guest.login',compact('title'));
 }
 public function showRegisterPage()
 {

    $title =__("pages.register.page-title");
     return view('pages.guest.register',compact('title'));
 }
 public function showForgetPasswordPage()
 {
    $title =__("pages.forget-password.page-title");
     return view('pages.guest.forgetPassword',compact('title'));
 }
 public function changePasswordPage()
 {
    $title =__("pages.change-password.page-title");
     return view('pages.user.changePassword',compact('title'));
 }
 public function changeEmailPage()
 {
    $title =__("pages.change-email.page-title");
     return view('pages.user.changeEmail',compact('title'));
 }


 public function logout(Request $request)
{

    Auth::logout(); // Log the user out
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate the CSRF token

    // Optionally, you can redirect the user to a specific page after logout
    return redirect('/');
}
}


