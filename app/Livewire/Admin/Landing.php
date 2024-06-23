<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Landing\ManageForm;
use App\Models\GeneralSetting;
use App\Models\Image;
use App\Traits\GeneralTrait;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Landing extends Component
{

    use WithFileUploads,GeneralTrait;
    public ManageForm $form;
    public GeneralSetting $gSetting;
    public $temporaryImageUrl="";




    public function updated($property)
    {
        try {
            if ($property === "form.logo" ) {

                $this->temporaryImageUrl="";
                    if (!$this->form->logo->temporaryUrl()) {
                        $this->temporaryImageUrl ="";
                    }else{
                    $this->temporaryImageUrl = $this->form->logo->temporaryUrl();
                    }

            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.common.img-err')]);
        }
    }


    public function mount()
    {


            try {
                $this->gSetting = GeneralSetting::first();
              $logo = Image::where('imageable_id', $this->gSetting->id)
              ->where('imageable_type','App\Models\GeneralSetting')
              ->where('use_case','logo')->first();
               $this->temporaryImageUrl= $logo?->url ?? "";

                $this->form->fill([
                    'id' => $this->gSetting->id,
                    'landline'=>$this->gSetting->landline,
                    'email'=>$this->gSetting->email,
                    'phone'=>$this->gSetting->phone,
                    'fax'=>$this->gSetting->fax,
                    'map'=>$this->gSetting->map,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }

    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =$this->form->save($this->gSetting);
        if ($response['status']) {

            $this->dispatch('logo-updated');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }



    public function render()
    {
        return view('livewire.admin.Landing');
    }
}
