<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "name",
        "path",
        "url",
        "status",
        "size",
        "use_case",
        "fileable_id",
        "fileable_type"
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
