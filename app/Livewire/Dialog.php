<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{


    public $isOpen = false;
    public $question = "";
    public $details =[];
    public $actionEvent=[];

    #[On("open-dialog")]
    public function openDialog($data)
    {
        $this->isOpen = true;
        $this->question = $data['question'];
        $this->details = $data['details'];
        $this->actionEvent = $data['actionEvent'];
    }


    public function closeDialog()
    {
        $this->isOpen = false;
        $this->question ='';
        $this->details = [];
        $this->actionEvent= [];
    }


    public function confirmAction(){

       if(isset($this->actionEvent['parameters']))
         {
          $this->dispatch($this->actionEvent['event'],$this->actionEvent['parameters']);
          }
        else {
            $this->dispatch($this->actionEvent['event']);
        }

        $this->dispatch("user-chose-yes");
   }

    public function render()
    {
        return view('livewire.dialog');
    }
}
