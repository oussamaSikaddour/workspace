<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait GeneralTrait
{

    function checkAndUpdateArray(&$array, $value)
{
    $index = array_search($value, $array);
    if ($index !== false) {
        // Value exists, remove it
        unset($array[$index]);
    } else {
        // Value doesn't exist, add it
        $array[] = $value;
    }
}


    public function populateSelectorOption($data,$optionsList,$key,$value){

        if(isset($data) && count($data) > 0) {
            foreach ($data as $d) {
                $optionsList[$d->$key] = $d->$value;
            }
        }
        return $optionsList;

    }


    public function populateSpecialtiesOptions($specialties){
    return $this->populateSelectorOption(
          $specialties,
         [""=>""],
          "specialty",
           "specialty"
         );
  }



    public function populateUsersOptions($personnel,$defaultOptionValue){
     return  $this->populateSelectorOption(
            $personnel,
            [""=>$defaultOptionValue],
            "id",
            "name"
           );
    }
 public function populateConsultationPlacesOptions($consultationPlaces){
  return  $this->populateSelectorOption(
            $consultationPlaces,
            [""=>__("selectors.default-option.c-places")],
             "id",
             "name"
           );
}


public function findAttributeKey($attributeToFind, $data) {
    foreach ($data as $key => $value) {
        if (strtolower($value) === strtolower($attributeToFind)) {
            return $key;
        }
    }

    return null; // Return null if no match is found
}


public function findSpecialtyKey($specialtyToFind) {
    $specialtyToFindLower = strtolower($specialtyToFind);
    $specialtyOptions = app('my_constants')['SPECIALTY_OPTIONS'];

    foreach (["ar", "fr", "en"] as $lang) {
        $foundKey = $this->findAttributeKey($specialtyToFindLower, $specialtyOptions[$lang]);
        if ($foundKey !== null) {
            return $foundKey;
        }
    }

    return null; // Return null if no match is found
}
public function findDairaKey($dairaToFind) {
    $dairaToFindLower = strtolower($dairaToFind);
    $dairaOptions = app('my_constants')['DAIRAS'];

    foreach (["ar", "fr", "en"] as $lang) {
        $foundKey = $this->findAttributeKey($dairaToFindLower, $dairaOptions[$lang]);
        if ($foundKey !== null) {
            return $foundKey;
        }
    }

    return null; // Return null if no match is found
}


protected function calculateWorkingHoursPerDay($startTime, $endTime)
{
    $start = strtotime($startTime);
    $end = strtotime($endTime);

    if ($start > $end) {
        $end += 86400; // Add 24 hours in seconds if end time is smaller (e.g., end time is the next day)
    }

    $diff = $end - $start;
    $totalHours = $diff / (60 * 60); // Convert seconds to hours

    return $totalHours;
}




protected function getTotalDays($startDate, $endDate, $workingDays = [],$hourly =false)
{
    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);

    if ($startDate > $endDate) {
        return 0; // Invalid date range, return 0
    }

    $totalDays = $endDate->diffInDays($startDate) + 1; // Calculate the total days of the period

    if( count($workingDays) > 0 && $hourly){
    $daysOff = $startDate->diffInDaysFiltered(function ($date) use ($workingDays) {
        return !in_array($date->dayOfWeek, $workingDays);
    }, $endDate);

    $totalDays -= $daysOff; // Subtract the non-working days from the total days
    }
    return $totalDays;
}

public function parseDate($date){
    return Carbon::parse($date)->format('Y-m-d');
}
}
