<?php

namespace App\Livewire;

use App\Models\Training;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PagesTrainings extends Component
{

    use WithPagination, TableTrait,GeneralTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $capacity = "";
    #[Url()]
    public $pricePerSession = "";
    #[Url()]
    public $totalPrice = "";


public function resetFilters(){
$this->name="";
$this->capacity="";
$this->pricePerSession="";
$this->totalPrice="";
 }






    #[Computed()]
    public function trainings()
    {

            $query =Training::with('image');
            if(app()->getLocale() === 'ar'){
           $query->where('name_ar', 'like', "%{$this->name}%");
            }
            if(app()->getLocale() === 'fr'){
             $query->where('name_fr', 'like', "%{$this->name}%");
            }

            if ($this->capacity !=="") {
                $query->where('capacity','>=' ,$this->capacity);
              }

              // Filter by date end (inclusive)
              if ($this->pricePerSession !=="") {
                $query->where('price_per_session',  $this->pricePerSession);
              }
              if ($this->totalPrice !=="") {
                $query->where('price_total',  $this->totalPrice);
              }
            $query->orderBy($this->sortBy, $this->sortDirection);

            return $query->paginate($this->perPage);
    }












    public function updated($property){

        if(in_array($property,['name','capacity','pricePerSession','totalPrice','perPage','sortBy','sortDirection'])){
            $this->resetPage();
        }

    }



public function placeholder(){
return view('components.pages-loader');
}
    public function render()
    {
        return view('livewire.pages-trainings');
    }
}
