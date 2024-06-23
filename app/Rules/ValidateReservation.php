<?php

namespace App\Rules;

use App\Models\Classroom;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class ValidateReservation implements ValidationRule
{
  protected Classroom $classroom;
  protected Carbon $startDate;
  protected bool $hourly;
  protected Carbon $startTime;
  protected Carbon $closeTime;
  public $currentReservationDays ;

  public function __construct($classroom, $startDate, $hourly, $startTime, $closeTime, $currentReservationDays =[])
  {
    $this->classroom = $classroom;
    $this->startDate = Carbon::parse($startDate);
    $this->hourly = $hourly;
    $this->startTime = Carbon::parse($startTime);
    $this->closeTime = Carbon::parse($closeTime);
    $this->currentReservationDays= $currentReservationDays;
  }

  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
      if (count($this->currentReservationDays) === 0) {
          return;
      }

      $endDate = Carbon::parse($value);

      $reservations = $this->classroom->reservations()->where(function ($query) use ($endDate) {
          $query->whereBetween('start_date', [$this->startDate, $endDate])
              ->orWhereBetween('end_date', [$this->startDate, $endDate])
              ->orWhere(function ($query) use ($endDate) {
                  $query->where('start_date', '<', $this->startDate)
                        ->where('end_date', '>', $endDate);
              });
      })->get();

      if ($reservations->isEmpty()) {
          return; // No overlapping reservations, so valid
      }

      $overlappingReservations = [];
      foreach ($reservations as $reservation) {
          $reservationDays = explode(',', $reservation->reservation_days);
          // Filter overlapping days between current and reservation days
          $overlappingDays = array_intersect($this->currentReservationDays, $reservationDays);
          if (count($overlappingDays) > 0) {
              $reservationStartTime = Carbon::parse($reservation->start_time);
              $reservationEndTime = Carbon::parse($reservation->end_time);
              // Early return for non-hourly overlaps
              if (!$this->hourly || !$reservation->hourly) {
                  $overlappingReservations[] = $reservation;
              } else {
                  $timeOverlap = $this->checkForOverlap($this->startTime, $this->closeTime, $reservationStartTime, $reservationEndTime);
                  if ($timeOverlap) {
                      $overlappingReservations[] = $reservation;
                  }
              }
          }
      }

      // Dump the counter after the loop completes


      if (!empty($overlappingReservations)) {
          $this->generateFailMessage($fail, $overlappingReservations);
      }
  }


  protected function checkForOverlap($startDateOrTime, $endDateOrTime, $reservationStartDateOrTime, $reservationEndDateOrTime): bool | null
  {
      return $startDateOrTime->between($reservationStartDateOrTime, $reservationEndDateOrTime->subSecond())
          || $endDateOrTime->between($reservationStartDateOrTime->addSecond(), $reservationEndDateOrTime)
          || ($reservationStartDateOrTime < $startDateOrTime && $reservationEndDateOrTime > $endDateOrTime);
  }

  protected function generateFailMessage(Closure $fail, array $overlappingReservations ): void
  {
      $overlappingText = [];
      foreach ($overlappingReservations as $reservation) {


          $startDate = Carbon::parse($reservation['start_date'])->format('d/m/Y');
          $endDate = Carbon::parse($reservation['end_date'])->format('d/m/Y');

          if($reservation->hourly){
          $startTime = app('my_constants')['HOURS'][$reservation['start_time']] ?? "";
          $endTime = app('my_constants')['HOURS'][$reservation['end_time']] ?? "";

          $overlappingText[]= __('rules.reservation.overLappingReservation.hourly', [
              "dateStart" => $startDate,
              "dateEnd" => $endDate,
              "timeStart" => $startTime,
              "timeEnd" => $endTime,
          ]);
          }else{
            $overlappingText[]= __('rules.reservation.overLappingReservation.daily', [
                "dateStart" => $startDate,
                "dateEnd" => $endDate,
            ]);
          }
      }

     $overlappingText= implode(",",$overlappingText);
      $fail(__('rules.reservation.overLappingReservations', [
          "overLappingReservations" => $overlappingText,
      ]));
  }


}
