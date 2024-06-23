<?php

namespace App\Livewire\Scenes\Landing;

use App\Models\AboutUs as ModelsAboutUs;
use App\Models\OurQuality;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AboutUs extends Component
{


public $aboutUs;


 #[Computed()]
public function qualities(){
return OurQuality::with('image')->where("status", "1")->get();
}

 public function mount()
 {
   $this->aboutUs= ModelsAboutUs::first();

 }





    public function render()
    {
        return view('livewire.scenes.landing.about-us');
    }
}
