<?php
return [
    'days-off' => [
        'not-valid' => 'La :attribute sélectionnée entre en conflit avec un jour de congé existant. Le jour de congé commence le :start et se termine le :end.',
    ],
    'reservation' => [
        'hasDaysOff' => 'La période que vous avez sélectionnée pour la réservation de la salle de classe entre en conflit avec les jours de congé de la salle de classe, qui commencent à :start et se terminent à :end.',
        'workingHours' => 'Les heures de début et de fin que vous avez sélectionnées pour la réservation ne correspondent pas aux heures de travail de la salle de classe, qui sont de :openTime à :closeTime.',
        'workingDays' => 'Les jours que vous avez sélectionnés pour la réservation ne correspondent pas aux jours de travail de la salle de classe, qui sont :workingDays.',
        'datesOverlapWorkingDays' => 'Au moins un jour de la période que vous avez sélectionnée pour la réservation de la  salle de classe doit chevaucher les jours de travail de la salle de classe, qui sont :workingDays.',
        'overLappingReservation' => [
            'daily' => 'Une réservation pour une journée complète (Date : :dateStart à :dateEnd)',
            'hourly' => 'Une réservation à l\'heure (Date : :dateStart à :dateEnd, Heure : :timeStart à :timeEnd)',
        ],
        'overLappingReservations' => 'Il y a des réservations qui se chevauchent : :overLappingReservations',


    ],

];
