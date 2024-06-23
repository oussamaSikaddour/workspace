<?php

namespace App\Rules;

use App\Models\Classroom;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateWorkingDays implements ValidationRule
{
    protected Classroom $classroom; // Property to store classroom ID




    public function __construct($classroom)
    {
        $this->classroom = $classroom;
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

        $workingDays = explode(',', $this->classroom->working_days);

        if (!empty(array_diff($value, $workingDays))) {
            $workingDaysText = [];
            foreach ($workingDays as $day) {
                $workingDaysText[] = app('my_constants')['WEEK_DAYS'][app()->getLocale()][$day];
            }
            $workingDaysText = implode(', ', $workingDaysText);

            $fail(__('rules.reservation.workingDays', [
                "workingDays" => $workingDaysText,
            ]));
        }
    }

}
