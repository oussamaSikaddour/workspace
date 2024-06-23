<?php

namespace App\Livewire\Admin\SiteParameters;

use App\Livewire\Forms\SiteParameters\FirstForm as SiteParametersFirstForm;
use Livewire\Component;


class FirstForm extends Component
{

 public SiteParametersFirstForm $form;
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =  $this->form->save();
       if ($response['status']) {
           $this->dispatch('open-toast', $response['message']); // Corrected the variable name
           $this->dispatch('first-step-succeeded');
            $this->form->reset();
         }else{
            $this->dispatch('open-errors', $response['errors']);
         }

    }
    public function render()
    {
        return view('livewire.admin.site-parameters.first-form');
    }
}
