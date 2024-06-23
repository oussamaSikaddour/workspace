<?php

namespace App\Livewire;

use App\Models\Classroom;
use Livewire\Component;

class ClassroomShowcase extends Component
{

    public $classroomId = "";
    public $classroom = null;
    public $primaryImgUrl = "";
    public $name = "";
    public $description = "";
    public $workingDays=[];
    public $modalData=[];



    public function goBack() {
        $previousUrl = session()->get('previousUrl');
        if ($previousUrl) {
          session()->forget('previousUrl'); // Optional: Clear session after use
          return redirect()->to($previousUrl);
        } else {
          // Handle case where no previous URL exists (e.g., redirect to homepage)
          return redirect()->to('/');
        }
      }

    public function setPrimaryImage($imageId)
  {

      $this->dispatch('set-thumbnail-active',$imageId);
      if (!auth()->user() || !auth()->user()->can("admin-access")) {
        return;  // Access denied for non-admin users
      }

    // Update all images to 'classroom' use_case
    $this->classroom->images->each(function ($image) {
      $image->use_case = 'classroom';
      $image->save();
    });

    // Update clicked image to 'classroom_primary' use_case
    $clickedImage = $this->classroom->images->find($imageId);
    $clickedImage->use_case = 'classroom_primary';
    $clickedImage->save();

    $this->primaryImgUrl = $clickedImage->url;
  }
  protected function getPrimaryImageUrl()
  {
      if (!$this->classroom) {
          return "";
      }
      $primaryImage = $this->classroom->images->firstWhere('use_case', 'classroom_primary')
                    ?? $this->classroom->images->firstWhere('use_case', 'classroom');
      if ($primaryImage) {
          $this->dispatch('set-thumbnail-active', $primaryImage->id);
          return $primaryImage->url ?? "";
      }
      return "";
  }



    public function mount()
    {

        session()->put('previousUrl', url()->previous());
        $this->modalData= [
            "title"=>"modals.reservation.for.add",
             "component"=>[
                          "name"=>'user.reservation-modal',
                           "parameters"=> [ "classroomId"=>$this->classroomId]
             ],
            ];

      $this->classroom = Classroom::with('images')->where('id', $this->classroomId)->first();
      $this->primaryImgUrl = $this->getPrimaryImageUrl();
       $this->workingDays = explode(',',$this->classroom->working_days);
      $this->name = app()->getLocale() === 'ar' ? $this->classroom->name_ar : $this->classroom->name_fr;
      $this->description = app()->getLocale() === 'ar' ? $this->classroom->description_ar : $this->classroom->description_fr;
    }

    public function render()
    {
        return view('livewire.classroom-showcase');
    }
}
