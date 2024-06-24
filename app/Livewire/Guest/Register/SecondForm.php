<?php

namespace App\Livewire\Guest\Register;

use App\Enums\RoutesNamesEnum;
use App\Events\Auth\EmailVerificationEvent;
use App\Livewire\Forms\register\SecondForm as RegisterSecondForm;
use App\Models\User;
use Livewire\Component;

class SecondForm extends Component
{
    public RegisterSecondForm $form;

    public function setEmail($email)
    {
        $this->form->email =$email;
    }
    public function setNewValidationCode(){
        try {
            $user = User::where('email', $this->form->email)->first();
            event(new EmailVerificationEvent($user));
            $this->dispatch('open-toast','new verification code was sent to your email');
            } catch (\Exception $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
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
        return view('livewire.guest.register.second-form');
    }
}
