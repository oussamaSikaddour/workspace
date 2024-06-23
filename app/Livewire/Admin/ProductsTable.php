<?php

namespace App\Livewire\Admin;

use App\Models\Image;
use App\Models\Product;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsTable extends Component
{

    use WithPagination, TableTrait,GeneralTrait,ImageTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $quantity = "";
    #[Url()]
    public $price = "";

    #[Url()]
    public $statusOptions = [];




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




    #[On("selected-value-updated")]
    public function changeStatusForProduct(Product $entity, $value){
        try {
            $count =Product::where('status', '1')->count();
            if($count <= 3 || $value ==="0"){
                $entity->status = $value;
                $entity->save();
            }else{
                $this->dispatch('selected-value-reset',$entity->id, 0);
                throw new \Exception(__("tables.products.active-limit-err"));
            }
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
    }
    #[On("delete-product")]
    public function deleteService(Product $product)
    {
        try {

            $images = Image::where('imageable_id', $product->id)
            ->where('imageable_type','App\Models\Product')->get();
            // ->where('use_case','product')->get();

            if(isset($images)){
                $this->deleteImages($images);
            }
            $product->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }





    public function updated($property){


        if(in_array($property,['quantity','name','price','perPage','sortBy','sortDirection'])){

            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.admin.products-table');
    }
}
