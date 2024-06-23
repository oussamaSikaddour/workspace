<?php

namespace App\Rules;

use App\Models\Classroom;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class ValidateOverlappingReservationDaysCount implements ValidationRule
{

    protected $startDate;
    protected Classroom $classroom;





    public function __construct($startDate,$classroom)
    {
        $this->startDate = $startDate;
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
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($value);

        if ($startDate > $endDate) {
            return;
        }

        $totalDays = $endDate->diffInDays($startDate) + 1;

        // Retrieve working days as an array of integers representing days of the week
        $workingDays = array_map('intval', explode(",", $this->classroom->working_days));

        if ($totalDays > 7) {
            return;
        }

        // Calculate the overlapping days
        $overlappingDaysCount = 0;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            if (in_array($currentDate->dayOfWeek, $workingDays)) {
                $overlappingDaysCount++;
            }
            $currentDate->addDay();
        }

        if ($overlappingDaysCount === 0) {
            $workingDaysText = array_map(function ($day) {
                return app('my_constants')['WEEK_DAYS'][app()->getLocale()][$day];
            }, $workingDays);

            $workingDaysText = implode(', ', $workingDaysText);

            $fail(__('rules.reservation.datesOverlapWorkingDays', [
                "workingDays" => $workingDaysText,
            ]));
        }
    }
}
