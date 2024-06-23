<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\OurQuality\AddForm;
use App\Livewire\Forms\OurQuality\UpdateForm;
use App\Models\Image;
use App\Models\OurQuality;
use App\Traits\GeneralTrait;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class OurQualityModal extends Component
{

    use WithFileUploads,GeneralTrait;
    public AddForm $addForm;
    public UpdateForm $updateForm;
    public OurQuality $ourQuality;
    public $id = "";
    public $temporaryImageUrl='';




    public function updated($property)
    {
        try {

            if ($property === "addForm.image" && $this->addForm->image) {
                $this->temporaryImageUrl="";

                    if (!$this->addForm->image->temporaryUrl()) {
                        $this->temporaryImageUrl = ""; // Set to empty array if any image
                    }else{
                        $this->temporaryImageUrl = $this->addForm->image->temporaryUrl();
                    }


            }
            if ($property === "updateForm.image" && $this->updateForm->image) {
                $this->temporaryImageUrl="";

                    if (!$this->updateForm->image->temporaryUrl()) {
                        $this->temporaryImageUrl = ""; // Set to empty array if any image
                    }else{
                        $this->temporaryImageUrl = $this->updateForm->image->temporaryUrl();
                    }


            }

        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.common.img-err')]);
        }
    }


    public function mount()
    {

        if ($this->id !== "") {
            try {
              $this->ourQuality = OurQuality::findOrFail($this->id);

              $image = Image::where('imageable_id', $this->id)
              ->where('imageable_type','App\Models\OurQuality')
              ->where('use_case','our_quality')->first();
               $this->temporaryImageUrl = $image?->url ?? "";
                $this->updateForm->fill([
                    'id' => $this->id,
                    'name_fr'=>$this->ourQuality->name_fr,
                    'name_ar'=>$this->ourQuality->name_ar,
                    'description_fr'=>$this->ourQuality->description_fr,
                    'description_ar'=>$this->ourQuality->description_ar,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response = ($this->id !== "")
            ? $this->updateForm->save($this->ourQuality)
            : $this->addForm->save();

            if ($this->id === "") {
                $this->addForm->image="";
                $this->temporaryImageUrl="";
        }

        if ($response['status']) {
            $this->dispatch('update-our-qualities-table');
            $this->dispatch('open-toast', $response['message']);
            if ($this->id === "") {
                $this->addForm->reset();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    public function render()
    {
        return view('livewire.admin.our-quality-modal');
    }
}
