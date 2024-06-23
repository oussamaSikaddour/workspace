<?php

namespace App\Livewire\Forms;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;


class ChangeEmailForm extends Form
{

    use ResponseTrait;
    public $newEmail ='';
    public $oldEmail ='';
    public $password ='';





    // Livewire rules
    public function rules()
    {
        return [
            'newEmail' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' =>  'required|min:8|max:255',
            'oldEmail' => ['required', 'email', "exists:users,email"],
        ];
    }


    public function validationAttributes()
    {
        return [
            'oldEmail' =>__("forms.change-email.old-email"),
            'newEmail' =>__("forms.change-email.new-email"),
            'password' =>__("forms.change-email.pwd")
        ];
    }


    public function save()
    {
        $data = $this->validate();

        try {
            if (Auth::attempt(['email' => $data['oldEmail'], 'password' => $data['password']])) {
                $user = Auth::user();
                $user->email = $data['newEmail'];
                $user->save();
                return $this->response(true, message: __("forms.change-email.success-txt"));
            } else {
                throw new \Exception(__('forms.login.no-user-err'));
            }
        } catch (\Exception $e) {
            return $this->response(false, errors: [$e->getMessage()]);
        }
    }



}
