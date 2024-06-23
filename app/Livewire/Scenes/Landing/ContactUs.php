<?php

namespace App\Livewire\Scenes\Landing;

use App\Livewire\Forms\Message\AddForm;
use Livewire\Component;

class ContactUs extends Component
{

    public $map;
    public AddForm $form;





    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response = $this->form->save();
        $this->form->reset();
        if ($response['status']) {
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    public function render()
    {
        return view('livewire.scenes.landing.contact-us');
    }
}
