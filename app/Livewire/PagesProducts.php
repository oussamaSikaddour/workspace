<?php

namespace App\Livewire;

use App\Models\Product;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PagesProducts extends Component
{


    use WithPagination, TableTrait,GeneralTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $quantity = "";
    #[Url()]
    public $price = "";


public function resetFilters(){
$this->name="";
$this->quantity="";
$this->price="";
 }






    #[Computed()]
    public function products()
    {

            $query =Product::query();
            if(app()->getLocale() === 'ar'){
           $query->where('name_ar', 'like', "%{$this->name}%");
            }
            if(app()->getLocale() === 'fr'){
             $query->where('name_fr', 'like', "%{$this->name}%");
            }

            if ($this->quantity !=="") {
                $query->where('quantity', $this->quantity);
              }

              // Filter by date end (inclusive)
              if ($this->price !=="") {
                $query->where('price',  $this->price);
              }
            $query->orderBy($this->sortBy, $this->sortDirection);

            return $query->paginate($this->perPage);
    }






    protected function getPrimaryImageUrl($product)
    {

        $primaryImage = $product->images->firstWhere('use_case', 'product_primary')
                      ?? $product->images->firstWhere('use_case', 'product');

        if ($primaryImage) {
            $this->dispatch('set-thumbnail-active', $primaryImage->id);
            return $primaryImage->url ?? "";
        }

        return "";
    }





    public function updated($property){

        if(in_array($property,['name','quantity','price','perPage','sortBy','sortDirection'])){
            $this->resetPage();
        }

    }



public function placeholder(){
return view('components.pages-loader');
}
    public function render()
    {
        return view('livewire.pages-products');
    }
}
