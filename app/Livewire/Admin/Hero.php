<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Hero\ManageForm;
use App\Models\Hero as ModelsHero;
use App\Models\Image;
use App\Traits\GeneralTrait;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Hero extends Component
{

    use GeneralTrait,WithFileUploads;
    public ManageForm $form;
    public ModelsHero $hero;
    public $temporaryImageUrls=[];





    public function updated($property)
    {
        try {
            if ($property === "form.images" && $this->form->images) {

                $this->temporaryImageUrls= [];
                foreach ($this->form->images as $image) {
                    if (!$image->temporaryUrl()) {
                        $this->temporaryImageUrls = []; // Set to empty array if any image doesn't have a temporary URL
                        break; // Exit the loop
                    }
                    $this->temporaryImageUrls[] = $image->temporaryUrl();
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.common.img-err')]);
        }
    }


    public function mount()
    {


            try {
                $this->hero = ModelsHero::first();

                $images = Image::where('imageable_id', $this->hero->id)
                ->where('imageable_type','App\Models\Hero')
                ->where('use_case','hero')->get();
                foreach($images as $image){
                 $this->temporaryImageUrls[] = $image?->url ?? "";
                }

                $this->form->fill([
                    'id' => $this->hero->id,
                    'title_fr' => $this->hero->title_fr,
                    'title_ar' => $this->hero->title_ar,
                    'sub_title_ar' => $this->hero->sub_title_ar,
                    'sub_title_fr' => $this->hero->sub_title_fr,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }

    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response =$this->form->save($this->hero);
        if ($response['status']) {
            $this->dispatch('open-toast', $response['message']);

        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }



    public function render()
    {
        return view('livewire.admin.hero');
    }
}
