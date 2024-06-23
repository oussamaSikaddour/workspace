<?php

namespace App\Livewire\User;

use App\Livewire\Forms\ChangePasswordForm;
use Livewire\Component;

class ChangePassword extends Component
{

    public ChangePasswordForm $form;


    public function redirectPage(){
        return redirect()->route('logout');
    }



    public function handelSubmit()
    {
        $this->dispatch('form-submitted');
        $response = $this->form->save();
        if ($response['status']) {
            // Redirect to the "logout" route by name
            $this->dispatch('redirect-page');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    public function render()
    {
        return view('livewire.user.change-password');
    }
}
