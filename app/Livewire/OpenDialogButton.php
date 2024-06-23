<?php

namespace App\Livewire;

use Livewire\Component;

class OpenDialogButton extends Component
{

    public $classes="";
    public $title="";
    public $content="";
    public $toolTipMessage="";
    public $data="";

    public function mount() {
      $this->dispatch("select_tooltip");
    }

    public function openDialog(){
         $this->dispatch("open-dialog",$this->data);
    }
    public function render()
    {
        return view('livewire.open-dialog-button');
    }
}
