<?php

namespace App\Livewire\Forms\Classroom;

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
    public $latitude;
    public $longitude;
    public $price_per_hour;
    public $price_per_day;
    public $price_per_week;
    public $price_per_month;
    public $open_time;
    public $close_time;
    public $capacity;
    public $working_days=[];
    public $images;


public function rules()
{
return [
    'name_fr' => ['required', 'string', 'max:255', Rule::unique('classrooms')->whereNull('deleted_at')->ignore($this->id)],
    'name_ar' => ['required', 'string', 'max:255', Rule::unique('classrooms')->whereNull('deleted_at')->ignore($this->id)],
    'description_fr' => 'nullable|string',
    'description_ar' => 'nullable|string',
    'capacity' => 'required|integer|min:1|max:100',
    'latitude' => 'required|string|max:255',
    'longitude' => 'required|string|max:255',
    'price_per_hour' => 'required|numeric|between:0,99999999.99',
    'price_per_day' =>'required|numeric|between:0,99999999.99',
    'price_per_week' => 'required|numeric|between:0,99999999.99',
    'price_per_month' => 'required|numeric|between:0,99999999.99',
    'open_time' => ['required', 'date_format:H:i:s'],
    'close_time' => ['required', 'date_format:H:i:s', 'after:open_time'],
    'working_days' => 'required|array|max:7',
    'working_days.*' => 'required|in:0,1,2,3,4,5,6',
    'images.*' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
    'images' => 'nullable|array|max:5',
];
 }



 public function validationAttributes()
 {
     return [
         'name_fr' => __("modals.classroom.nameFr"),
         'name_ar' => __("modals.classroom.nameAr"),
         'description_fr' =>  __("modals.classroom.descriptionFr"),
         'description_ar' =>  __("modals.classroom.descriptionAr"),
         'address_ar' =>  __("modals.classroom.addressAr"),
         'address_fr' => __("modals.classroom.addressFr"),
         'price_per_hour' => __("modals.classroom.pricePerHour"),
         'price_per_day' => __("modals.classroom.pricePerDay"),
         'price_per_week' => __("modals.classroom.pricePerWeek"),
         'price_per_month' => __("modals.classroom.pricePerMonth"),
         'open_time' => __("modals.classroom.openTime"),
         'close_time' => __("modals.classroom.closeTime"),
         'capacity'=>__("modals.classroom.capacity"),
         'working_days' => __("modals.classroom.workDays"),
         'images' => __("modals.classroom.image"),
     ];
 }






    public function save($classroom)
    {
        try {
           $validatedData = $this->validate();
            return DB::transaction(function () use ($validatedData,$classroom ) {

               if (isset($validatedData['working_days'])) {
                   $validatedData['working_days'] = implode(',', $validatedData['working_days']);
               }
                $classroom->update($validatedData);
                  if ($this->images) {
                      $this->uploadAndUpdateImages($this->images, $classroom->id, "App\Models\Classroom", "classroom");
                  }
                  return $this->response(true,message:__("forms.classroom.update.success-txt"));

            });
        } catch (\Exception $e) {
            return $this->response(false, errors: [$e->getMessage()]);
        }
    }
}
