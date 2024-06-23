<?php

namespace App\Rules;

use App\Models\Classroom;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateWorkingHours implements ValidationRule
{
    protected Classroom $classroom; // Property to store classroom ID
    protected $startTime;



    public function __construct($classroom,$startTime)
    {
        $this->classroom = $classroom;
        $this->startTime= $startTime;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

         if(!$this->startTime){
            return;
         }
        $classRoomOpened = ($this->classroom->open_time <= $this->startTime && $this->classroom->close_time >= $value);

      if (!$classRoomOpened) {
        $fail(__('rules.reservation.workingHours',
        [
        "openTime"=>app('my_constants')['HOURS'][$this->classroom->open_time],
        "closeTime"=>app('my_constants')['HOURS'][$this->classroom->close_time]
        ]));
      }
    }

}
