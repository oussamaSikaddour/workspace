<?php

namespace App\Livewire;

use Livewire\Component;

class Carousel extends Component
{


    public $showControls=true;
    public $variant="";
    public $slides = [];
    public function render()
    {
        return view('livewire.carousel');
    }
}
