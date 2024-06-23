<?php

namespace App\Livewire;

use App\Models\GeneralSetting;
use Livewire\Component;

class Footer extends Component
{
    public $gSettings;
    public $currentYear;

    public function mount(){
        $this->currentYear = date('Y');
     $this->gSettings = GeneralSetting::first();
    }
    public function render()
    {
        return view('livewire.footer');
    }
}
