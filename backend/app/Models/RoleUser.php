<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Pivot
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        'user_id', 'role_id',
    ];
}
