<?php

namespace App\Livewire\Forms;

use App\Models\Establishment;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Form;

class LoginForm extends Form
{
    use ResponseTrait;
    public $email ="";
    public $password ="";

    // Livewire rules
    public function rules()
    {
        return [
            'email' => ['required', 'email', "exists:users,email"],
            'password' =>  'required|min:8|max:255'
        ];
    }


    public function validationAttributes()
    {
        return [

            'email' => __('forms.login.email'),
            'password' => __('forms.login.password'),
            // Add more attribute names as needed
        ];
    }




    public function save()
    {
        $data = $this->validate();
        try {
            if (RateLimiter::tooManyAttempts('login', 5, 10)) {

                throw new \Exception( __('forms.login.too-many-attempts'));
                 }

                if (Auth::attempt($data)) {
                    session()->regenerate();
                     return $this->response(true);
                 } else
                 {
                     RateLimiter::hit('login');
                    throw new \Exception( __('forms.login.no-user-err'));
                }

        } catch (\Exception $e) {
            return $this->response(false, errors:[$e->getMessage()]);
        }
    }





}
