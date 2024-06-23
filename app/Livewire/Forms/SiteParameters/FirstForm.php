<?php

namespace App\Livewire\Forms\SiteParameters;

use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FirstForm extends Form
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

            'email' =>__('forms.site-params.first-f.email'),
            'password' => __('forms.site-params.first-f.password'),
            // Add more attribute names as needed
        ];
    }




    public function save()
    {
        // // Validate the data
        $data = $this->validate();

        try {

                if (Auth::attempt($data)) {
                  $user = Auth::user();
                   $userIsSuperAdmin= $user->roles->contains('slug', 'super_admin');
                 if(!$userIsSuperAdmin){
                    throw new \Exception(__('forms.site-params.first-f.no-access'));
                 }else{

                    return $this->response(true,message:
                                               __('forms.site-params.first-f.success-txt'));
                   }
                 } else {
                   throw new \Exception(__('forms.site-params.first-f.no-user'));
                   }

        } catch (\Exception $e) {


            return $this->response(false,errors:[$e->getMessage()]);
        }
    }



}
