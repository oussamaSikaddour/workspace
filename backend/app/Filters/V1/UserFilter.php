<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class UserFilter extends ApiFilter

{
    protected $allwedParms = [
        'name' => ["eq", "like"],
        'email' => ["eq", "like"],
        'createdAt' => ["eq", "lt", "gt", 'lte', "gte"],
        'updatedAt' => ["eq", "lt", "gt", 'lte', "gte"],
        "userableType" => ["eq", "like"],
    ];

    protected $columnMap = [
        "createdAt" => "created_at",
        "updatedAt" => "updated_at",
        "userableType" => "userable_type",
    ];
    protected  $operatorMap = [
        "eq" => "=",
        "like" => "like",
        "lt" => "<",
        "lte" => "<=",
        "gt" => ">",
        "gte" => ">="
    ];
}
