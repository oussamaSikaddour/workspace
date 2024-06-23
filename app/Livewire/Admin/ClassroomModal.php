<?php

namespace App\Livewire\Admin;


use App\Livewire\Forms\Classroom\AddForm;
use App\Livewire\Forms\Classroom\UpdateForm;
use App\Models\Classroom;
use App\Models\Image;
use App\Traits\GeneralTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ClassroomModal extends Component
{

    use WithFileUploads,GeneralTrait;
    public AddForm $addForm;
    public UpdateForm $updateForm;
    public Classroom $classRoom;
    public $descriptionFr="";
    public $descriptionAr="";
    public $id = "";
    public $temporaryImageUrls=[];




    public function updated($property)
    {
        try {

            if ($property === "addForm.images" && $this->addForm->images) {

                $this->temporaryImageUrls=[];
                foreach ($this->addForm->images as $image) {
                    if (!$image->temporaryUrl()) {
                        $this->temporaryImageUrls = []; // Set to empty array if any image doesn't have a temporary URL
                        break; // Exit the loop
                    }
                    $this->temporaryImageUrls[] = $image->temporaryUrl();
                }
            }

            if ($property === "updateForm.images" && $this->updateForm->images) {

                $this->temporaryImageUrls= [];
                foreach ($this->updateForm->images as $image) {
                    if (!$image->temporaryUrl()) {
                        $this->temporaryImageUrls = []; // Set to empty array if any image doesn't have a temporary URL
                        break; // Exit the loop
                    }
                    $this->temporaryImageUrls[] = $image->temporaryUrl();
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.slide.pic-type-err')]);
        }
    }


    public function mount()
    {

        $this->dispatch('initialize-tiny-mce');
        if ($this->id !== "") {
            try {
              $this->classRoom = Classroom::findOrFail($this->id);
               $this->descriptionAr=$this->classRoom->description_ar;
               $this->descriptionFr=$this->classRoom->description_fr;
              $images = Image::where('imageable_id', $this->id)
              ->where('imageable_type','App\Models\Classroom')
              ->where('use_case','classroom')->get();
              foreach($images as $image){
               $this->temporaryImageUrls[] = $image?->url ?? "";
              }
                $this->updateForm->fill([
                    'id' => $this->id,
                    'name_fr'=>$this->classRoom->name_fr,
                    'name_ar'=>$this->classRoom->name_ar,
                    'description_fr'=>$this->classRoom->description_fr,
                    'description_ar'=>$this->classRoom->description_ar,
                    'longitude'=>$this->classRoom->longitude,
                    'latitude'=>$this->classRoom->latitude,
                    'price_per_hour'=>$this->classRoom->price_per_hour,
                    'price_per_day'=>$this->classRoom->price_per_day,
                    'price_per_week'=>$this->classRoom->price_per_week,
                    'price_per_month'=>$this->classRoom->price_per_month,
                    'open_time'=>$this->classRoom->open_time,
                    'close_time'=>$this->classRoom->close_time,
                    'capacity'=>$this->classRoom->capacity,
                    'working_days'=>explode(',',$this->classRoom->working_days)
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
            ? $this->updateForm->save($this->classRoom)
            : $this->addForm->save();
            if ($this->id === "") {
                $this->addForm->images=[];
                $this->temporaryImageUrls=[];
        }
        if ($response['status']) {
            $this->dispatch('update-classrooms-table');
            $this->dispatch('open-toast', $response['message']);
            if ($this->id === "") {
                $this->addForm->reset();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    #[On('set-description-fr')]
    public function setDescriptionFr($content)
    {
     if ($this->id !== "") {
        $this->updateForm->fill([
            'description_fr'=>$content
        ]);
     }else{
         $this->addForm->fill([
             'description_fr'=>$content
         ]);
     }
    }
    #[On('set-description-ar')]
    public function setDescriptionAr($content)
    {
     if ($this->id !== "") {
        $this->updateForm->fill([
            'description_ar'=>$content
        ]);
     }else{
         $this->addForm->fill([
             'description_ar'=>$content
         ]);
     }
    }
    public function render()
    {
        return view('livewire.admin.classroom-modal');
    }
}
