<?php

namespace App\Livewire\Forms\OurQuality;

use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{
    use ResponseTrait,ImageTrait ;
    public $id;
    public $name_fr;
    public $name_ar;
    public $image;




public function rules()
{
return [
    'name_fr' => ['required', 'string', 'max:255', Rule::unique('our_qualities')->ignore($this->id)],
    'name_ar' => ['required', 'string', 'max:255', Rule::unique('our_qualities')->ignore($this->id)],
    'image' => 'nullable|file|mimes:jpeg,jpg,png,gif,ico,webp|max:10000',
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


 public function save($oq)
 {

     try {

        $validatedData = $this->validate();
         return DB::transaction(function () use ($validatedData,$oq ) {

             $oq->update($validatedData);
               if ($this->image) {
                   $this->uploadAndUpdateImage($this->image, $oq->id, "App\Models\OurQuality", "our_quality");
               }
               return $this->response(true,message:__("forms.ourQuality.update.success-txt"));

         });
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }
}
