<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Training\AddForm;
use App\Livewire\Forms\Training\UpdateForm;
use App\Models\Image;
use App\Models\Training;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class TrainingModal extends Component
{

    use WithFileUploads,GeneralTrait;
    public AddForm $addForm;
    public UpdateForm $updateForm;
    public Training $training;
    public $descriptionFr="";
    public $descriptionAr="";
    public $id = "";
    public $temporaryImageUrl='';
    public $formatterOptions=[];
    public $minDateEnd="";
    public $minDateStart="";





    #[Computed()]
    public function formatters()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('slug', 'formatter');
        })->get(['id', 'name']);
        return $users;

    }


    public function updated($property)
    {
        if($property ==="addForm.start_at"){
            $this->minDateEnd=
            Carbon::parse($this->addForm->start_at)->addDays(1)->toDateString();
            $this->addForm->end_at= $this->minDateEnd;
             }
        try {

            if ($property === "addForm.image" && $this->addForm->image) {

                $this->temporaryImageUrl="";

                    if (!$this->addForm->image->temporaryUrl()) {
                        $this->temporaryImageUrl = ''; // Set to empty array if any image doesn't have a temporary URL

                    }else{
                    $this->temporaryImageUrl = $this->addForm->image->temporaryUrl();
                    }

            }

            if ($property === "updateForm.image" && $this->updateForm->image) {

                $this->temporaryImageUrl="";

                if (!$this->updateForm->image->temporaryUrl()) {
                    $this->temporaryImageUrl = ''; // Set to empty array if any image doesn't have a temporary URL

                }else{
                $this->temporaryImageUrl = $this->updateForm->image->temporaryUrl();
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.common.img-type-err',[__('modals.training.img')])]);
        }
    }


    public function mount()
    {


        $this->formatterOptions = $this->populateUsersOptions($this->formatters(),__('selectors.default-option.formatter'));
        $this->dispatch('initialize-tiny-mce');

        $this->minDateStart = Carbon::tomorrow()->toDateString();
        if ($this->id !== "") {
            try {
              $this->training = Training::findOrFail($this->id);
               $this->descriptionAr=$this->training->description_ar;
               $this->descriptionFr=$this->training->description_fr;
              $image = Image::where('imageable_id', $this->id)
              ->where('imageable_type','App\Models\Training')
              ->where('use_case','training')->first();
              if($image){
               $this->temporaryImageUrl = $image?->url ?? "";
              }
                $this->updateForm->fill([
                    'id' => $this->id,
                    'name_fr'=>$this->training->name_fr,
                    'name_ar'=>$this->training->name_ar,
                    'description_fr'=>$this->training->description_fr,
                    'description_ar'=>$this->training->description_ar,
                    'capacity'=>$this->training->capacity,
                    'price_total'=>$this->training->price_total,
                    'price_per_session'=>$this->training->price_per_session,
                    'start_at'=>$this->training->start_at,
                    'end_at'=>$this->training->end_at,
                    'status'=>$this->training->status,
                    'user_id'=>$this->training->user_id
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
            ? $this->updateForm->save($this->training)
            : $this->addForm->save();
            if ($this->id === "") {
                $this->addForm->image=null;
                $this->temporaryImageUrl="";
        }
        if ($response['status']) {
            $this->dispatch('update-trainings-table');
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
        return view('livewire.admin.training-modal');
    }
}
