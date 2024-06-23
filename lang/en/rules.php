<?php
 return [
    'days-off' => [
        'not-valid' => 'The selected :attribute conflicts with an existing day off. Day off starts on :start and ends on :end.',
    ],
    "reservation"=>[
        "hasDaysOff"=>'The period you selected for the classroom reservation conflicts with the classroom days off, which start at :start and end at :end.',
        "workingHours"=>"The start and end times you selected for the reservation do not align with the classroom's working hours, which are from: :openTime - :closeTime",
        "workingDays"=>"The days you selected for the reservation do not correspond to the classroom's working weekdays, which are :workingDays",
        "datesOverlapWorkingDays"=>'At least one day of the period you selected for the classroom reservation must overlap with the classroom\'s working days, which are: :workingDays.',
        'overLappingReservation' => [
            "hourly"=>'A full day reservation (Date: :dateStart to :dateEnd)',
            "daily"=>' A Hourly Reservation  (Date: :dateStart to :dateEnd, Time: :timeStart to :timeEnd)'
        ],
        'overLappingReservations' => 'There are overlapping reservations: :overLappingReservations',
    ]

 ];
