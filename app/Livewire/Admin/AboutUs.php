<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\AboutUs\ManageForm;
use App\Models\AboutUs as ModelsAboutUs;
use App\Models\Image;
use App\Traits\GeneralTrait;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AboutUs extends Component
{
    use WithFileUploads,GeneralTrait;
    public ManageForm $form;
    public ModelsAboutUs $aUs;
    public $temporaryImageUrl="";




    public function updated($property)
    {
        try {
            if ($property === "form.image" ) {

                $this->temporaryImageUrl="";
                    if (!$this->form->image->temporaryUrl()) {
                        $this->temporaryImageUrl ="";
                    }else{
                    $this->temporaryImageUrl = $this->form->image->temporaryUrl();
                    }

            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.common.img-err')]);
        }
    }


    public function mount()
    {


            try {
                $this->aUs = ModelsAboutUs::first();

              $image = Image::where('imageable_id', $this->aUs->id)
              ->where('imageable_type','App\Models\AboutUs')
              ->where('use_case','image')->first();
               $this->temporaryImageUrl= $image?->url ?? "";
                $this->form->fill([
                    'id' => $this->aUs->id,
                    'title_ar'=>$this->aUs->title_ar,
                    'title_fr'=>$this->aUs->title_fr,
                    'description_fr'=>$this->aUs->description_fr,
                    'description_ar'=>$this->aUs->description_ar,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }

    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =$this->form->save($this->aUs);
        if ($response['status']) {
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    public function render()
    {
        return view('livewire.admin.about-us');
    }
}
