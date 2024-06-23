<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Socials\ManageForm;
use App\Models\Social;
use App\Traits\GeneralTrait;
use Livewire\Component;

class Socials extends Component
{


    use GeneralTrait;
    public ManageForm $form;
    public Social $socials;






    public function mount()
    {


            try {
                $this->socials = Social::first();

                $this->form->fill([
                    'id' => $this->socials->id,
                    'youtube' => $this->socials->youtube,
                    'facebook' => $this->socials->facebook,
                    'github' => $this->socials->github,
                    'linkedin' => $this->socials->linkedin,
                    'instagram' => $this->socials->instagram,
                    'tiktok' => $this->socials->tiktok,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }

    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =$this->form->save($this->socials);
        if ($response['status']) {
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    public function render()
    {
        return view('livewire.admin.socials');
    }
}
