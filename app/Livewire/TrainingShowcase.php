<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\Training;
use Livewire\Component;

class TrainingShowcase extends Component
{

    public $trainingId = "";
    public $training = null;
    public $imgUrl = "";
    public $name = "";
    public $description = "";
    public  File $trainerCv;



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

    public function mount()
    {

        session()->put('previousUrl', url()->previous());
      $this->training = Training::with(['image','trainer'])->where('id', $this->trainingId)->first();

      $this->trainerCv = File::where('fileable_id', $this->training->trainer->id)
      ->where('fileable_type', "App\Models\User")
      ->where("use_case", 'cv')->first();
      $this->imgUrl = $this->training->image->url;
      $this->name = app()->getLocale() === 'ar' ? $this->training->name_ar : $this->training->name_fr;
      $this->description = app()->getLocale() === 'ar' ? $this->training->description_ar : $this->training->description_fr;
    }

    public function render()
    {
        return view('livewire.training-showcase');
    }
}
