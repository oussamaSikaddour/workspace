<?php

namespace App\Livewire\Scenes\Landing;

use App\Models\Training;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Trainings extends Component
{





    #[Computed()]
public function ourTrainings(){
    return Training::with('image')->where("status", "1")->get();

    }
    public function render()
    {
        return view('livewire.scenes.landing.trainings');
    }
}
