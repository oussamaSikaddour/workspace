<?php

namespace App\Livewire\Scenes\Landing;

use App\Models\Hero as ModelsHero;
use Livewire\Component;

class Hero extends Component
{

    public $hero;
    public $logoUrl ="";
    public function mount(){
        $this->hero= ModelsHero::first();
    }
    public function render()
    {
        return view('livewire.scenes.landing.hero');
    }
}
