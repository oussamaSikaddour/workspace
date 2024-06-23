<?php

namespace App\Livewire\Forms\Register;
use App\Events\Auth\EmailVerificationEvent;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Form;

class FirstForm extends Form
{
    use ResponseTrait;
    public $email ='';
    public $password ="";




    // Livewire rules
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users','email')->whereNull('deleted_at'),
            ],


            'password' => 'required|min:8|max:255',

        ];
    }


    public function validationAttributes()
    {
        return [
             'email' => __('forms.register.first-f.email'),
             'password' =>__('forms.register.first-f.password'),
        ];
    }

// Import the DB facade

    public function save()
    {
        return DB::transaction(function () {
            $data = $this->validate();
            try {
                $default = [
                    'email' => $data['email'],
                    "password" => Hash::make($data['password']),
                    "name"=>""
                ];
                $user = User::create($default);

                $personalInfo = [
                    'user_id' => $user->id,
                ];
                PersonnelInfo::create($personalInfo);

                event(new EmailVerificationEvent($user));

                $defaultRoleSlugs = [config('defaultRole.default_role_slug', 'user')];
                $user->roles()->attach(Role::whereIn('slug', $defaultRoleSlugs)->get());

                return $this->response(true,message:__('forms.register.first-f.success-txt'));
            } catch (\Exception $e) {
                return $this->response(false,errors:[$e->getMessage()]);
            }
        });
    }



}
