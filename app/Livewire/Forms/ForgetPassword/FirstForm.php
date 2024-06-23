<?php

namespace App\Livewire\Forms\ForgetPassword;

use App\Events\Auth\EmailVerificationEvent;
use App\Models\User;
use App\Traits\ResponseTrait;
use Livewire\Form;


class FirstForm extends Form
{

    use ResponseTrait;
    public $email ='';





    // Livewire rules
    public function rules()
    {
        return [
            'email' => ['required', 'email', "exists:users,email"]
        ];
    }


    public function validationAttributes()
    {
        return [
            'email' =>__("forms.forget-pwd.first-f.email")
            // Add more attribute names as needed
        ];
    }


    public function save()
    {


       $data =$this->validate();
       try{
               $user= User::where("email", $data['email'])->first();
          event(new EmailVerificationEvent($user));
         return $this->response(true,message:__("forms.forget-pwd.first-f.success-txt"));
       } catch (\Exception $e) {
          return $this->response(false,errors:[$e->getMessage()]);
         }

    }


}
