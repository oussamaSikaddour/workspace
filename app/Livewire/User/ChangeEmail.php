<?php

namespace App\Livewire\User;

use App\Livewire\Forms\ChangeEmailForm;
use Livewire\Component;

class ChangeEmail extends Component
{

    public ChangeEmailForm $form;



    public function redirectPage(){
        return redirect()->route('logout');
    }



    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response = $this->form->save();
        if ($response['status']) {
            $this->dispatch('redirect-page');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    public function render()
    {
        return view('livewire.user.change-email');
    }
}
