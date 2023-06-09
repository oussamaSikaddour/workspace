<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class PlanningFilter extends ApiFilter

{
    protected $allwedParms = [
        'name' => ["eq", "like"],
        'year' => ["eq", "like"],
        'month' => ["eq", "like"],
        'createdBy' => ["eq"],
        'serviceId' => ["eq"],
    ];

    protected $columnMap = [
        "createdBy" => "created_by",
        "serviceId" => "service_id"
    ];
    protected  $operatorMap = [
        "eq" => "=",
        "like" => "like"
    ];
}
