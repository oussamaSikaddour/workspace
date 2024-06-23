<?php

namespace App\Livewire;

use Livewire\Component;

class TinyMceTextArea extends Component
{

    public $content = "";
    public $htmlId = "";
    public $contentUpdatedEvent = 'content-updated'; // Default event name


    public function mount()
    {
        $this->dispatch('initialize-tiny-mce'); // Emit event to initialize on mount
    }

    public function render()
    {
        return view('livewire.tiny-mce-text-area');
    }

    public function setContent($value)
    {
        $this->content = $value;
        $this->dispatch($this->contentUpdatedEvent, $value); // Dispatch default event
    }
}
