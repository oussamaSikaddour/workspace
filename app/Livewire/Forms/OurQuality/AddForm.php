<?php

namespace App\Livewire\Forms\OurQuality;

use App\Models\OurQuality;
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
    public $image;





public function rules()
{
return [
    'name_fr' => ['required', 'string', 'max:255', Rule::unique('our_qualities')],
    'name_ar' => ['required', 'string', 'max:255', Rule::unique('our_qualities')],
    'image' => 'required|file|mimes:jpeg,jpg,png,gif,ico,webp|max:10000',

];
 }



 public function validationAttributes()
 {
     return [
         'name_fr' => __("modals.ourQuality.nameFr"),
         'name_ar' => __("modals.ourQuality.nameAr"),
         'image' => __("modals.ourQuality.image"),
     ];
 }


 public function save()
 {

     try {

        $validatedData = $this->validate();
         return DB::transaction(function () use ($validatedData, ) {

             $oq=OurQuality::create($validatedData);
               if ($this->image) {
                   $this->uploadAndCreateImage($this->image, $oq->id, "App\Models\OurQuality", "our_quality");
               }
               return $this->response(true,message:__("forms.ourQuality.add.success-txt"));

         });
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }
}
