<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class RoutesController extends Controller
{




public function showAdminPage()
{

$title =__("pages.dashboard.page-title");

 return view('pages.admin.dashboard',compact('title'));
 }
public function showMessagesPage()
{

$title =__("pages.messages.page-title");

 return view('pages.admin.messages',compact('title'));
 }
public function showClassroomsPage()
{

$title =__("pages.classrooms.page-title");
$modalData= [
    "title"=>"modals.classroom.for.add",
     "component"=>[
                  "name"=>'admin.classroom-modal',
                   "parameters"=> []
     ],
     "containsTinyMce"=>true
    ];
 return view('pages.admin.classrooms',compact('title','modalData'));
 }
public function showTrainingsPage()
{

$title =__("pages.trainings.page-title");
$modalData= [
    "title"=>"modals.training.for.add",
     "component"=>[
                  "name"=>'admin.training-modal',
                   "parameters"=> []
     ],
     "containsTinyMce"=>true
    ];
 return view('pages.admin.trainings',compact('title','modalData'));
 }


 public function showTrainingPage($trainingId)
 {
 $title =__("pages.product.page-title");

 return view('pages.training',compact('title','trainingId'));
  }
public function showSiteParametersPage()
{
$title =__("pages.site-params.page-title");
 return view('pages.admin.site-parameters',compact('title'));
 }



 public function showDayOffPage($classroomId)
{
$title =__("pages.dayoff.page-title");
$modalData= [
             "title"=>"modals.days-off.for.add",
              "component"=>[
                           "name"=>'admin.days-off-modal',
                           "parameters"=> [
                            "classroomId"=>$classroomId
                                 ],
                           ]
             ];


return view('pages.admin.dayoff',compact('title','modalData','classroomId'));
 }

 public function showClassroomPage($classroomId)
 {
 $title =__("pages.classroom.page-title");

 return view('pages.classroom',compact('title','classroomId'));
  }
 public function showClassroomsPagesPage()
 {
 $title =__("pages.classrooms-pages.page-title");

 return view('pages.classrooms',compact('title'));
  }
 public function showProductsPage()
{
$title =__("pages.products.page-title");

$modalData= [
             "title"=>"modals.product.for.add",
              "component"=>[
                           "name"=>'admin.product-modal',
                           "parameters"=> [
                                 ],
                                ],
             "containsTinyMce"=>true
             ];

return view('pages.admin.products',compact('title','modalData'));
 }

 public function showProductPage($productId)
 {
 $title =__("pages.product.page-title");

 return view('pages.product',compact('title','productId'));
  }


  public function showProductsPagesPage()
  {
  $title =__("pages.products-pages.page-title");

  return view('pages.products',compact('title'));
   }
  public function showTrainingsPagesPage()
  {
  $title =__("pages.trainings-pages.page-title");

  return view('pages.trainings',compact('title'));
   }
public function showUsersPage()
{
$title =__("pages.users.page-title");
$modalData= [
             "title"=>"modals.user.for.add",
              "component"=>[
                           "name"=>'admin.user-modal',
                            "parameters"=> ['userableId'=>'1','userableType'=>'admin']
                           ]
             ];

return view('pages.admin.users',compact('title','modalData'));
 }

 public function showUserPage()
 {
  $title =__("pages.user-space.page-title");
 return view('pages.user.home',compact('title'));
 }
 public function showProfilePage()
 {
  $title =__("pages.profile.page-title");
 return view('pages.user.profile',compact('title'));
 }
 public function showManageLandingPage()
 {
  $title =__("pages.manage-landing.page-title");
 return view('pages.admin.manage-landing',compact('title'));
 }
 public function showManageHeroPage()
 {
  $title =__("pages.manage-hero.page-title");
 return view('pages.admin.manage-hero',compact('title'));
 }
 public function showManageSocialsPage()
 {
  $title =__("pages.manage-socials.page-title");
 return view('pages.admin.manage-socials',compact('title'));
 }

 public function showManageAboutUsPage()
 {
 $title =__("pages.manage-aboutUs.page-title");

 $modalData= [
              "title"=>"modals.ourQuality.for.add",
               "component"=>[
                            "name"=>'admin.our-quality-modal',
                            "parameters"=> [
                                  ],
                                 ],
              ];

 return view('pages.admin.manage-about-us',compact('title','modalData'));
  }


}

