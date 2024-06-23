<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "name",
        "path",
        "url",
        "size",
        "width",
        "height",
        "status",
        "use_case",
        "imageable_id",
        "imageable_type"
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
