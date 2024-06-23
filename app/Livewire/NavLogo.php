<?php

namespace App\Livewire;

use App\Models\GeneralSetting;
use Livewire\Component;

class NavLogo extends Component
{
    public $gSettings;

    public function mount(){
     $this->gSettings = GeneralSetting::first();
    }

    public function render()
    {
        return view('livewire.nav-logo');
    }
}
