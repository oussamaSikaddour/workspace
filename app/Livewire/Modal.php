<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;
    public $title = "";
    public $type="";
    public $component = [];
    public $containsTinyMce=false;

    #[On("open-modal")]
    public function openModal($data)
    {
        $this->isOpen = true;
        $this->title = $data['title'];
        $this->type = isset($data['type']) ? $data['type'] : '';
        $this->component = $data['component'];
        $this->containsTinyMce = isset($data['containsTinyMce'])?$data["containsTinyMce"]:"false";
    }


    public function closeModal()
    {
        $this->isOpen = false;
        $this->title = "";
        $this->type="";
        $this->component =[];
        $this->containsTinyMce=false;
    }





    public function render()
    {
        return view('livewire.modal');
    }
}
