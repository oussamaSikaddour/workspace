<?php

namespace App\Livewire\Forms\DaysOff;

use App\Models\DayOff;
use App\Rules\AlreadyHasADaysOff;
use App\Traits\ResponseTrait;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait;
    public $classroom_id;
    public $days_off_start;
    public $days_off_end;


public function rules()
{

    $validationAttributes = $this->validationAttributes();
    $now = now()->toDateString();
    return [
        'classroom_id' => 'required|exists:classrooms,id',
        'days_off_start' => [
            'required',
            'date',
            "after:$now",
            new AlreadyHasADaysOff($this->classroom_id,$validationAttributes['days_off_start'])

        ],
        'days_off_end' => [
            'required',
            'date',
            'after_or_equal:days_off_start',
            new AlreadyHasADaysOff($this->classroom_id,$validationAttributes['days_off_end'])
        ],
    ];
 }



 public function validationAttributes()
 {
     return [
         'days_off_start' => __("modals.days-off.days-off-start"),
         'days_off_end' => __("modals.days-off.days-off-end"),
     ];
 }



    public function save()
    {
        $validatedData = $this->validate();
        try {
          DayOff::create($validatedData);
       return $this->response(true,message:__("forms.daysOff.add.success-txt"));
        } catch (\Exception $e) {
            return $this->response(false, errors: [$e->getMessage()]);
        }
    }


}
