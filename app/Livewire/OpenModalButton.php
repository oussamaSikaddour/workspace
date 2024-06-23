<?php

namespace App\Livewire;

use Livewire\Component;

class OpenModalButton extends Component
{

    public $classes="";
    public $title="";
    public $content="";
    public $toolTipMessage="";
    public $data="";


    public function openModal(){
         $this->dispatch("open-modal",$this->data);
    }
    public function render()
    {
        return view('livewire.open-modal-button');
    }
}
