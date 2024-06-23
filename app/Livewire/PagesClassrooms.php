<?php

namespace App\Livewire;

use App\Models\Classroom;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PagesClassrooms extends Component
{


    use WithPagination, TableTrait,GeneralTrait;

    // Properties with default values

    #[Url()]
    public $capacity = "";
    #[Url()]

    public $minDateEnd="";
    public $minDateStart="";
    public $dateStart="";
    public $dateEnd="";
    public $openTime="";
    public $closeTime="";
    public $workingDays=[];






public function resetFilters(){
 $this->capacity="";
$this->minDateEnd="";
$this->minDateStart="";
$this->dateStart="";
$this->dateEnd="";
$this->openTime="";
$this->closeTime="";
$this->workingDays=[];
 }

    public function callUpdatedSelectedChoiceOnKeyDownEvent(){
        $this->updatedSelectedChoice();
     }





     #[Computed()]
     public function classrooms()
     {
         $query = Classroom::with(['images', 'reservations', 'daysOff']);

         if ($this->capacity) {
            $query->where('capacity', '>=', $this->capacity);
          }

         $query->when($this->dateStart && $this->dateEnd, function ($query) {
             // Filter classrooms that have NO days off overlapping with the date range
             $query->whereDoesntHave('daysOff', function ($query) {
                 $query->where(function ($query) {
                     $query->whereBetween('days_off_start', [$this->dateStart, $this->dateEnd])
                         ->orWhereBetween('days_off_end', [$this->dateStart, $this->dateEnd])
                         ->orWhere(function ($query)  {
                             $query->where('days_off_start', '<', $this->dateStart)
                                 ->where('days_off_end', '>', $this->dateEnd);
                         });
                 });
             });
         });
         $query->when($this->openTime || $this->closeTime, function ($query) {
            $query->where(function ($query) {
                if ($this->openTime && $this->closeTime) {
                    $query->where('open_time', '<=', $this->openTime)
                          ->where('close_time', '>=', $this->closeTime)
                          ->where(function ($query) {
                              $query->where('close_time', '>', $this->openTime)
                                    ->orWhere('open_time', '<', $this->closeTime);
                          });
                } elseif ($this->openTime) {
                    $query->where('open_time', '<=', $this->openTime)
                          ->where('close_time', '>', $this->openTime);
                } elseif ($this->closeTime) {
                    $query->where('open_time', '<', $this->closeTime)
                          ->where('close_time', '>=', $this->closeTime);
                }
            });
        });



       $query->when(count($this->workingDays) > 0, function ($query) {
        $query->where(function ($query) {
            $query->whereJsonContains('working_days', $this->workingDays) // Exact match
                  ->orWhere(function ($query) {
                      foreach ($this->workingDays as $day) {
                          $query->whereRaw('FIND_IN_SET(?, working_days)', [$day]);
                      }
                  });
        });
         });
         $query->orderBy($this->sortBy, $this->sortDirection);
         return $query->paginate($this->perPage);
     }






    protected function getPrimaryImageUrl($classroom)
    {

        $primaryImage = $classroom->images->firstWhere('use_case', 'classroom_primary')
                      ?? $classroom->images->firstWhere('use_case', 'classroom');

        if ($primaryImage) {
            $this->dispatch('set-thumbnail-active', $primaryImage->id);
            return $primaryImage->url ?? "";
        }

        return "";
    }

public  function updatedWorkingDays(){
    $this->resetPage();
    session()->put("workingDays", $this->workingDays);
}

public function mount(){

    $this->capacity = session()->get('capacity', '');
  $this->dateStart= session()->get('dateStart', '');
  $this->dateEnd= session()->get('dateEnd', '');
 $this->openTime= session()->get('openTime', '');
 $this->closeTime= session()->get('closeTime', '');
    $this->workingDays= session()->get('workingDays', []);
    if (count($this->workingDays) > 0) {
        // Explicit check for changes in workingDays
        $this->resetPage();
    }
    $this->minDateStart = Carbon::today()->toDateString();
}



    public function updated($property){



        if($property ==="dateStart"){
            $this->minDateEnd=
            Carbon::parse($this->dateStart)->addDays(1)->toDateString();
            $this->dateEnd= $this->minDateEnd;
         }
        if(in_array($property,['capacity','name','perPage','sortBy','sortDirection','dateStart',"dateEnd","openTime","closeTime"])){
            $this->resetPage();
        }
        if(in_array($property,['capacity','name','dateStart',"dateEnd",'openTime',"closeTime"])){
            session()->put($property, $this->$property);
        }


    }



public function placeholder(){
return view('components.pages-loader');
}
    public function render()
    {
        return view('livewire.pages-classrooms');
    }
}
