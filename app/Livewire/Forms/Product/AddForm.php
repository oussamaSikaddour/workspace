<?php

namespace App\Livewire\Forms\Product;

use App\Models\Product;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait,ImageTrait ;
    public $name_fr;
    public $name_ar;
    public $description_fr;
    public $description_ar;
    public $quantity;
    public $price;
    public $images;




public function rules()
{
return [
    'name_fr' => ['required', 'string', 'max:255', Rule::unique('products')],
    'name_ar' => ['required', 'string', 'max:255', Rule::unique('products')],
    'description_fr' => 'nullable|string',
    'description_ar' => 'nullable|string',
    'quantity' => 'required|integer|min:1|max:200',
    'price' => 'required|integer|min:10',
    'images.*' => 'required|file|mimes:jpeg,png,gif,ico,webp|max:10000',
    'images' => 'required|array|max:5',
];
 }



 public function validationAttributes()
 {
     return [
         'name_fr' => __("modals.product.nameFr"),
         'name_ar' => __("modals.product.nameAr"),
         'description_fr' =>  __("modals.product.descriptionFr"),
         'description_ar' =>  __("modals.product.descriptionAr"),
         'quantity' =>  __("modals.product.quantity"),
         'price' =>  __("modals.product.price"),
         'images' => __("modals.product.image"),
     ];
 }


 public function save()
 {

     try {

        $validatedData = $this->validate();
         return DB::transaction(function () use ($validatedData, ) {

             $product= Product::create($validatedData);
               if ($this->images) {
                   $this->uploadAndCreateImages($this->images, $product->id, "App\Models\Product", "product");
               }
               return $this->response(true,message:__("forms.product.add.success-txt"));

         });
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }
}
