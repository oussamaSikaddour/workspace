<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public $isOpen = false;
    public $message = "";

    #[On('open-toast')]
    public function openToast($message)
    {
        $this->message = $message; // Set message only when opening
        $this->toggleToast();
    }

    public function toggleToast()
    {
        $this->isOpen = !$this->isOpen;
        $this->dispatch("handle-toast-state"); // Use dispatchBrowserEvent
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
