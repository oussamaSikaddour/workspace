<?php

namespace App\Livewire\Admin;

use App\Models\Classroom;
use App\Models\Image;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ClassroomsTable extends Component
{

    use WithPagination, TableTrait,GeneralTrait,ImageTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $capacity = "";
    #[Url()]
    public $status = "";


    #[Url()]
    public $statusOptions = [];




public function resetFilters(){
$this->name="";
$this->capacity="";
$this->status="";
 }

    public function callUpdatedSelectedChoiceOnKeyDownEvent(){
        $this->updatedSelectedChoice();
     }





    #[Computed()]
    public function classrooms()
    {

            $query =Classroom::query();
            if(app()->getLocale() === 'ar'){
           $query->where('name_ar', 'like', "%{$this->name}%");
            }
            if(app()->getLocale() === 'fr'){
             $query->where('name_fr', 'like', "%{$this->name}%");
            }
            $query->orderBy($this->sortBy, $this->sortDirection);
            return $query->paginate($this->perPage);
    }




    #[On("selected-value-updated")]
    public function changeStatusForProduct(Classroom $entity, $value){
        try {
            $count =Classroom::where('status', '1')->count();
            if($count <= 3 || $value ==="0"){
                $entity->status = $value;
                $entity->save();
            }else{
                $this->dispatch('selected-value-reset',$entity->id, 0);
                throw new \Exception(__("tables.classrooms.active-limit-err"));
            }
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
    }

    #[On("delete-classroom")]
    public function deleteService(Classroom $classroom)
    {
        try {
            $images = Image::where('imageable_id', $classroom->id)
            ->where('imageable_type','App\Models\Classroom')
            ->where('use_case','classroom')->get();

            if(isset($images)){
                $this->deleteImages($images);
            }
            $classroom->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }





    public function updated($property){


        if(in_array($property,['capacity','name','perPage','sortBy','sortDirection'])){

            $this->resetPage();
        }
    }



    // public function placeholder(){

    //     return view('components.loading',['variant'=>'l']);
    // }
    public function render()
    {
        return view('livewire.admin.classrooms-table');
    }
}
