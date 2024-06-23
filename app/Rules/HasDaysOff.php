<?php

namespace App\Rules;

use App\Models\DayOff;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasDaysOff implements ValidationRule
{
    protected $classroomId; // Property to store classroom ID
    protected $date;



    public function __construct($classroomId,$date)
    {
        $this->classroomId = $classroomId;
        $this->date= $date;
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

        $daysOff = DayOff::where('classroom_id', $this->classroomId)
        ->where(function ($query) use ($value) {
            $query->where(function ($query) {
                // Case 1: $this->date falls within the days off range
                $query->where('days_off_start', '<=', $this->date)
                    ->where('days_off_end', '>=', $this->date);
            })
            ->orWhere(function ($query) use ($value) {
                // Case 2: $value falls within the days off range
                $query->where('days_off_start', '<=', $value)
                    ->where('days_off_end', '>=', $value);
            })
            ->orWhere(function ($query) use ($value) {
                // Case 3: The days off range falls within the range from $this->date to $value
                $query->where('days_off_start', '>=', $this->date)
                    ->where('days_off_end', '<=', $value);
            })
            ->orWhere(function ($query) use ($value) {
                // Case 4: The days off range falls within the range from $value to $this->date
                $query->where('days_off_start', '>=', $value)
                    ->where('days_off_end', '<=', $this->date);
            });
        })
        ->first();


      if ($daysOff) {
        $fail(__('rules.reservation.hasDaysOff', [
          'start' => $daysOff->days_off_start,
          'end' => $daysOff->days_off_end,
        ]));
      }
    }

}
