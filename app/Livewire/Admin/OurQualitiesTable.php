<?php

namespace App\Livewire\Admin;

use App\Models\Image;
use App\Models\OurQuality;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OurQualitiesTable extends Component
{

    use WithPagination, TableTrait,GeneralTrait,ImageTrait;

    // Properties with default values
    #[Url()]
    public $name = "";


    #[Url()]
    public $statusOptions = [];




public function resetFilters(){
$this->name="";

 }






    #[Computed()]
    public function ourQualities()
    {

            $query =OurQuality::query();
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
    public function changeStatusForOurQuality(OurQuality $entity, $value){
        try {
            $count =OurQuality::where('status', '1')->count();
            if($count <= 3 || $value ==="0"){
                $entity->status = $value;
                $entity->save();
            }else{
                $this->dispatch('selected-value-reset',$entity->id, 0);
                throw new \Exception(__("tables.ourQualities.active-limit-err"));
            }
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
    }
    #[On("delete-ourQuality")]
    public function deleteOurQuality(OurQuality $ourQuality)
    {
        try {

            $images = Image::where('imageable_id', $ourQuality->id)
            ->where('imageable_type','App\Models\OurQuality')
            ->where('use_case','our_quality')->get();

            if(isset($images)){
                $this->deleteImages($images);
            }
            $ourQuality->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }







    public function updated($property){


        if(in_array($property,['name','perPage','sortBy','sortDirection'])){
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.admin.our-qualities-table');
    }
}
