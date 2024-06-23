<?php

namespace App\Livewire\Admin;

use App\Models\DayOff;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DaysOffTable extends Component
{

    use  TableTrait,GeneralTrait,WithPagination;

    // Properties with default values
    #[Url()]
    public $dateStart= "";
    #[Url()]
    public $dateEnd = "";
    public $classroomId="";



public function resetFilters(){
$this->dateStart="";
$this->dateEnd="";
 }





 #[Computed()]
 public function daysOff()
 {
   $query = DayOff::query();

   // Filter by classroom ID if provided
   if ($this->classroomId) {
     $query->where('classroom_id', $this->classroomId);
   }

   // Filter by date start (inclusive)
   if ($this->dateStart) {
     $query->where('days_off_start', '>=', $this->dateStart);
   }

   // Filter by date end (inclusive)
   if ($this->dateEnd) {
     $query->where('days_off_end', '<=', $this->dateEnd);
   }


   return $query->paginate($this->perPage);
 }




    #[On("delete-days-off")]
    public function deleteService(DayOff $daysOff)
    {
        try {
            $daysOff->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }







    public function updated($property){


        if(in_array($property,['dateStart','dateEnd','perPage','sortBy','sortDirection'])){

            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.admin.days-off-table');
    }
}
