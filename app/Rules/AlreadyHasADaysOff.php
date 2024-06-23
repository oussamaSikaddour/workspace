<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB; // Import for database access

class AlreadyHasADaysOff implements ValidationRule
{
    protected $classroomId; // Property to store classroom ID
    protected $attributeLabel;


    public function __construct($classroomId,$attributeLabel)
    {
        $this->classroomId = $classroomId;
        $this->attributeLabel = $attributeLabel;
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
      $existingDayOff = DB::table('day_offs')
        ->where('classroom_id', $this->classroomId)
        ->where('days_off_start', '<=', $value)
        ->where('days_off_end', '>=', $value)
        ->select('days_off_start', 'days_off_end')
        ->first(); // Fetch the first conflicting record

      if ($existingDayOff) {
        $fail(__('rules.days-off.not-valid', [
          'attribute' => $this->attributeLabel,
          'start' => $existingDayOff->days_off_start,
          'end' => $existingDayOff->days_off_end,
        ]));
      }
    }

}
