<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Livewire\Forms\ManageRolesForm;
use App\Models\Role;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Computed;

class ManageRolesModal extends Component
{
    use GeneralTrait;
    public ManageRolesForm $form;
    public ?int $id = null;
    public $user;


    public function redirectPage(){
        return redirect()->route('logout');
    }

    public function mount(int $id = null)
    {
        $this->id = $id;

        if (!is_null($id)) {
            try {
                $this->user = User::findOrFail($id);
                $this->form->roles = $this->user->roles->pluck('id')->toArray();
            } catch (ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }

    #[Computed]
    public function existingRoles()
    {
        return Role::all();
    }


    public function updateRolesOnKeydownEvent($value){
        $this->checkAndUpdateArray($this->form->roles,$value);
    }
    public function handleSubmit()
    {
        $response = $this->form->save($this->user);
        if ($response['status']) {

            // Check if the authenticated user's ID matches the ID being edited
            if (auth()->id() === $this->id) {
               // If the authenticated user's roles were changed, redirect to a page for reauthentication.
                // Replace 'your-login-page' with the actual route name for reauthentication.
                $this->dispatch('redirect-page');
                $this->dispatch('open-toast', "Vous avez changé vos propres rôles. vous serez déconnecté.");

            }else{
                $this->dispatch('open-toast', $response['message']);
            }


        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }

    public function render()
    {
        return view('livewire.admin.manage-roles-modal');
    }
}
