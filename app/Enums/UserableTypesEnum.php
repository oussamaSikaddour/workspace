<?php

namespace App\Enums;

enum UserableTypesEnum: string {
    const USER_TYPE = 'user';
    const ADMIN_TYPE = 'admin';
    const SERVICE_TYPE = 'admin_service';
    const ESTABLISHMENT_TYPE = 'admin_establishment';
    const PLACE_OF_CONSULTATION_TYPE = 'admin_place_of_consultation';
    const DOCTOR_TYPE = 'doctor';
}
