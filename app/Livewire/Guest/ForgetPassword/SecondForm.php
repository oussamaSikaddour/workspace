<?php

namespace App\Livewire\Guest\ForgetPassword;

use App\Enums\RoutesNamesEnum;
use App\Events\Auth\EmailVerificationEvent;
use App\Livewire\Forms\forgetPassword\SecondForm as FGPSecondForm;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class SecondForm extends Component
{
    public FGPSecondForm $form;



    public function setEmail($email){
        $this->form->email = $email;
    }

    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =  $this->form->save();
        if ($response['status']) {
            $this->reset();
            $this->dispatch('second-step-succeeded');
            redirect()->route(RoutesNamesEnum::USER_ROUTE);
            }else{
               $this->dispatch('open-errors', $response['errors']);
            }

    }

    public function render()
    {
        return view('livewire.guest.forget-password.second-form');
    }
}
