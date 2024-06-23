<?php

namespace App\Livewire\Forms\Reservation;

use App\Models\Classroom;
use App\Models\Notification;
use App\Models\Reservation;
use App\Rules\HasDaysOff;
use App\Rules\ValidateOverlappingReservationDaysCount;
use App\Rules\ValidateReservation;
use App\Rules\ValidateWorkingDays;
use App\Rules\ValidateWorkingHours;
use App\Traits\GeneralTrait;
use App\Traits\ResponseTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait,GeneralTrait ;

    public $user_id;
    public $classroom_id;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $capacity;
    public $total_price;
    public $number_of_days;
    public $hourly =false;
    public $reservation_days=[];





    public function rules()
    {
        $classroom = Classroom::where('id', $this->classroom_id)->first();
        $now = now()->toDateString();

        $rules = [
            'capacity' => 'required|numeric|between:1,' . $classroom->capacity,
            'start_date' => [
                'required',
                'date',
                "after:$now",
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                new HasDaysOff($this->classroom_id, $this->end_date),
                new ValidateReservation($classroom,$this->start_date,$this->hourly,$this->start_time,$this->end_time, $this->reservation_days),
                new ValidateOverlappingReservationDaysCount($this->start_date,$classroom)
            ],
            'hourly' => 'nullable|boolean',
            'reservation_days' => [
                'required',
                'array',
                'max:7',
                new ValidateWorkingDays($classroom),
            ],
            'reservation_days.*' => 'required|in:0,1,2,3,4,5,6',
        ];

        // Add required rules for start_time and end_time if hourly is true
        if ($this->hourly === true) {
            $rules['start_time'] = ['required', 'date_format:H:i:s'];
            $rules['end_time'] = [
                'required',
                'date_format:H:i:s',
                'after:' . $classroom->open_time,
                new ValidateWorkingHours($classroom, $this->start_time),
            ];
        }

        return $rules;
    }



 public function validationAttributes()
 {
     return [
         'start_date' => __('modals.reservation.startDate'),
         'end_date' => __('modals.reservation.endDate'),
         'start_time' => __('modals.reservation.startTime'),
         'close_time' => __('modals.reservation.closeTime'),
         'capacity' => __('modals.reservation.capacity'),
         'reservation_days' => __('modals.reservation.days'),
     ];
 }


 public function save()
 {
    $validatedData = $this->validate();
     try {
        $validatedData['classroom_id']=$this->classroom_id;
        $validatedData['user_id']=auth()->user()->id;
        $classroom = Classroom::where('id', $this->classroom_id)->first();
        $totalHours = $this->hourly ? $this->calculateWorkingHoursPerDay($this->start_time, $this->end_time) : null;
        $validatedData['number_of_days']= $this->getTotalDays($this->start_date, $this->end_date, $this->reservation_days,$this->hourly);
        $validatedData['total_price']=$this->calculateTotalPrice( $validatedData['number_of_days'],
        $classroom->price_per_hour,  $classroom->price_per_day,  $classroom->price_per_week,   $classroom->price_per_month,$totalHours);
        $validatedData['reservation_days'] = implode(',', $validatedData['reservation_days']);
        Reservation::create($validatedData);

        $notification = new Notification();
        $notification->message = 'new'; // Customize message
        $notification->for_type="reservation";
        $notification->targetable_type = 'admin';
        $notification->save();
        return $this->response(true,message:__("forms.reservation.add.success-txt"));
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }

 protected function calculateTotalPrice($totalDays,$hourlyRate, $dailyRate, $weeklyRate, $monthlyRate,$totalHours=null)
 {
    if ($totalHours > 0) {
        $totalPrice = $totalHours * $totalDays * $hourlyRate;
    } else {
        $totalPrice = 0;
        if ($totalDays < 7) {
            $totalPrice =  $totalDays * $dailyRate;
        } elseif ($totalDays < 30) {
            $numberOfWeeks = intdiv($totalDays, 7);
            $numberOfDays = $totalDays % 7;
            $priceForThePeriod = $numberOfWeeks * $weeklyRate + $numberOfDays * $dailyRate;
            $totalPrice = $priceForThePeriod;
        } else {
            $numberOfMonths = intdiv($totalDays, 30);
            $numberOfDays = $totalDays % 30;
            $numberOfWeeks = intdiv($numberOfDays, 30);
            $numberOfDays = $numberOfDays % 30;
            $priceForTheRest = $numberOfWeeks * $weeklyRate + $numberOfDays * $dailyRate;
            $totalPrice = $numberOfMonths * $monthlyRate + $priceForTheRest;
        }
    }

     return $totalPrice;
 }


}
