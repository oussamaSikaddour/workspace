<?php

namespace App\Livewire\Guest;

use App\Enums\RoutesNamesEnum;
use App\Livewire\Forms\LoginForm;
use Livewire\Component;

class Login extends Component
{

    public LoginForm $form;

    public function handelSubmit()
    {

        $this->dispatch('form-submitted');
        $response =  $this->form->save();
        $this->form->reset();
       if ($response['status']) {
        if (session()->get('currentClassRoomId') !== null) {
            return $this->redirectRoute('classroom', ['classroomId' => session()->get('currentClassRoomId')]);
          }
        return  $this->redirectRoute(RoutesNamesEnum::USER_ROUTE);
       }else{
        $this->dispatch('open-errors', $response['errors']);
         }
    }
    public function render()
    {
        return view('livewire.guest.login');
    }
}
