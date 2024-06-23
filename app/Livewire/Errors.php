<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Errors extends Component
{
    public $isOpen = false;
    public $errors = [];

    #[On('open-errors')]
    public function openErrors($errors)
    {
        $this->toggleErrors($errors);
    }

    public function toggleErrors($errors=[])
    {

        $this->isOpen = !$this->isOpen;
        $this->errors =count($errors)>0? $errors:[];
        $this->dispatch("handle-errors-state");
    }

    public function render()
    {
        return view('livewire.errors');
    }
}
