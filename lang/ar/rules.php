<?php
return [
    'days-off' => [
        'not-valid' => 'الـ :attribute المحدد يتعارض مع يوم إجازة موجود. يبدأ يوم الإجازة في :start وينتهي في :end.',
    ],
    'reservation' => [
        'hasDaysOff' => 'الفترة التي اخترتها لحجز القاعة تتعارض مع أيام عطلة القاعة، التي تبدأ في :start وتنتهي في :end.',
        'workingHours' => 'أوقات البدء والانتهاء التي اخترتها للحجز لا تتماشى مع ساعات عمل القاعة، والتي هي من :openTime إلى :closeTime.',
        'workingDays' => 'الأيام التي اخترتها للحجز لا تتوافق مع أيام عمل القاعة، والتي هي :workingDays.',
        'datesOverlapWorkingDays' => 'يجب أن يتداخل على الأقل يوم واحد من الفترة التي اخترتها لحجز القاعة مع أيام عمل القاعة، وهي :workingDays.',
        'overLappingReservation' => [
            'daily' => 'حجز ليوم كامل (التاريخ: :dateStart إلى :dateEnd)',
            'hourly' => 'حجز بالساعة (التاريخ: :dateStart إلى :dateEnd، الوقت: :timeStart إلى :timeEnd)',
        ],
        'overLappingReservations' => 'هناك حجوزات تتداخل: :overLappingReservations',
    ],
];
