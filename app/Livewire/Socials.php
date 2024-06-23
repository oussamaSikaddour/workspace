<?php

namespace App\Livewire;

use App\Models\Social;
use Livewire\Component;

class Socials extends Component
{

    public $socialLinks;
    public function mount(){

     $this->socialLinks = Social::first();
    }
    public function render()
    {
        return view('livewire.socials');
    }
}
