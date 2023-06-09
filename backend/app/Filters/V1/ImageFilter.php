<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class ImageFilter extends ApiFilter

{
    protected $allwedParms = [
        'name' => ["eq", "like"],
        'path' => ["eq", "like"],
        'useCase' => ["eq", "like"],
        'imageableId' => ["eq"],
    ];

    protected $columnMap = [
        "imageableId" => "imageable_id",
        "useCase" => "use_case"
    ];
    protected  $operatorMap = [
        "eq" => "=",
        "like" => "like"
    ];
}
