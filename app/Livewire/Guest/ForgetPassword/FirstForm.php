<?php

namespace App\Livewire\Guest\ForgetPassword;

use App\Livewire\Forms\forgetPassword\FirstForm as forgetPasswordFirstForm;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FirstForm extends Component
{


    public forgetPasswordFirstForm $form;
       public $forgetPasswordEmail;

    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $this->forgetPasswordEmail = $this->form->email;
        $response =  $this->form->save();
       if ($response['status']) {
           session(['forget-password-email' => $this->form->email]);
           $this->dispatch('open-toast', $response['message']); // Corrected the variable name
           $this->dispatch('first-step-succeeded');
            $this->form->reset();
         }else{
            $this->dispatch('open-errors', $response['errors']);
         }

    }

    public function render()
    {
        return view('livewire.guest.forget-password.first-form');
    }
}
