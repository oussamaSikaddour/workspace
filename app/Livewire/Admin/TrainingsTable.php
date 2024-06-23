<?php

namespace App\Livewire\Admin;

use App\Models\Image;
use App\Models\Training;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TrainingsTable extends Component
{
    use WithPagination, TableTrait,GeneralTrait,ImageTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $capacity = "";
    #[Url()]
    public $statusOptions = [];




public function resetFilters(){
$this->name="";
$this->capacity="";
 }






    #[Computed()]
    public function trainings()
    {

            $query =Training::query();
            if(app()->getLocale() === 'ar'){
           $query->where('name_ar', 'like', "%{$this->name}%");
            }
            if(app()->getLocale() === 'fr'){
             $query->where('name_fr', 'like', "%{$this->name}%");
            }

            if ($this->capacity !=="") {
                $query->where('quantity', $this->capacity);
              }
            $query->orderBy($this->sortBy, $this->sortDirection);

            return $query->paginate($this->perPage);
    }




    #[On("selected-value-updated")]
    public function changeStatusForTraining(Training $entity, $value){
        try {
            $count =Training::where('status', '1')->count();
            if($count <= 3 || $value ==="0"){
                $entity->status = $value;
                $entity->save();
            }else{
                $this->dispatch('selected-value-reset',$entity->id, 0);
                throw new \Exception(__("tables.trainings.active-limit-err"));
            }
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
    }
    #[On("delete-training")]
    public function deleteService(training $training)
    {
        try {

            $images = Image::where('imageable_id', $training->id)
            ->where('imageable_type','App\Models\training')
            ->where('use_case','training')->get();

            if(isset($images)){
                $this->deleteImages($images);
            }
            $training->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }

    public function updated($property){


        if(in_array($property,['capacity','name','perPage','sortBy','sortDirection'])){

            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.admin.trainings-table');
    }
}
