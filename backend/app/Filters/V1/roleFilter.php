<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class RoleFilter extends ApiFilter

{
    protected $allwedParms = [
        'id' => ["eq"],
        'name' => ["eq", "like"],
        'slug' => ["eq", "like"],

    ];

    protected $columnMap = [];
    protected  $operatorMap = [
        "eq" => "=",
        "like" => "like"
    ];
}
