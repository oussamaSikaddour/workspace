<?php

namespace App\Livewire\Forms\Training;

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
    public $description_fr;
    public $description_ar;
    public $capacity;
    public $start_at;
    public $end_at;
    public $image;
    public $user_id;
    public $price_total;
    public $price_per_session;




public function rules()
{

    $now = now()->toDateString();
return [
    'user_id' => 'required|exists:users,id',
    'name_fr' => ['required', 'string', 'max:255', Rule::unique('trainings')->whereNull('deleted_at')->ignore($this->id)],
    'name_ar' => ['required', 'string', 'max:255', Rule::unique('trainings')->whereNull('deleted_at')->ignore($this->id)],
    'description_fr' => 'nullable|string',
    'description_ar' => 'nullable|string',
    'price_total' => 'required|integer|min:10',
    'price_per_session' => 'sometimes|integer|min:10',
    'capacity' => 'required|integer|min:1|max:200',
    'start_at' => [
        'required',
        'date',
        "after:$now",

    ],
    'end_at' => [
        'required',
        'date',
        'after_or_equal:end_at',
    ],
    'image' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
];
 }



 public function validationAttributes()
 {
     return [
        'user_id'=>__('modals.training.formatter'),
         'name_fr' => __("modals.training.nameFr"),
         'name_ar' => __("modals.training.nameAr"),
         'description_fr' =>  __("modals.training.descriptionFr"),
         'description_ar' =>  __("modals.training.descriptionAr"),
         'capacity' =>  __("modals.training.capacity"),
         'price_total' =>  __("modals.training.priceTotal"),
         'price_per_session' =>  __("modals.training.pricePerSession"),
         'start_at' =>  __("modals.training.start_at"),
         'end_at' =>  __("modals.training.end_at"),
         'image' =>  __("modals.training.image"),
     ];
 }

 public function messages(): array
 {
     return [
         'user_id.required' => __("forms.common.user-id-error",["attribute"=>__('modals.training.formatter')]),
     ];
 }

 public function save($training)
 {
    try {

        $validatedData = $this->validate();
         return DB::transaction(function () use ($validatedData,$training ) {

             $training->update($validatedData);
               if ($this->image) {
                   $this->uploadAndUpdateImage($this->image, $training->id, "App\Models\Training", "training");
               }
               return $this->response(true,message:__("forms.training.update.success-txt"));

         });
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }
}
