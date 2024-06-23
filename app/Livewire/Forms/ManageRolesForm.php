<?php

namespace App\Livewire\Forms;

use App\Traits\ResponseTrait;
use Livewire\Form;

class ManageRolesForm extends Form
{

    use ResponseTrait;
public $roles =[];

    public function rules()
    {
        return [
            'roles'   => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'roles' => 'les privileges'
            // Add more attribute names as needed
        ];
    }


    public function save($user)
    {
        $validatedData = $this->validate();
        try {
            $user->roles()->sync($validatedData['roles']);
            return $this->response(true,message:("Les rôles ont été modifiés avec succès"));
        } catch (\Exception $e) {

            return $this->response(false,errors:[$e->getMessage()]);
        }
    }
}
