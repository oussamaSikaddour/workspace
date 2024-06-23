<?php

namespace App\Livewire\Forms\Register;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Otp;
class SecondForm extends Form
{
    use ResponseTrait;
    public $code ='';
    public $email ="";

    // Livewire rules
    public function rules()
    {
        return [
            'email' => ['required', 'email', "exists:users,email"],
            'code' => ['required', 'max:6'],
        ];
    }


    public function validationAttributes()
    {
        return [

            'email' => __("forms.register.second-f.email"),
            'code' => __("forms.register.second-f.code")
            // Add more attribute names as needed
        ];
    }




    public function save()
    {
        $data =$this->validate();
        try {
               // Attempt to find the user by email
                $user = User::where('email', $data['email'])->first();
                // Create an instance of the Otp class
                 $otp = new Otp();
                 // Validate the OTP code for the provided email
                 $validationResult = $otp->validate($data['email'], $data['code']);
               if ($validationResult->status){
                  // Update the user's password
                    // Authenticate the user
                   Auth::login($user);
                   return $this->response(true);
                  } else {
                    throw new \Exception(__("forms.register.second-f.code-err"));
                 }
        } catch (\Exception $e) {
            return $this->response(false,errors:[$e->getMessage()]);
       }


    }
}
