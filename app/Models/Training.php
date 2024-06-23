<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'name_fr',
        'name_ar',
        'description_ar',
        'description_fr',
        'price_per_session',
        'price_total',
        'capacity',
        'start_at',
        'end_at',
        'status',
        'user_id'
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function image():MorphOne{
        return $this->morphOne(Image::class, 'imageable');
    }
}
