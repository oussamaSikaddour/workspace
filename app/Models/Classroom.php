<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name_fr','name_ar','capacity', 'description_ar','description_fr', 'longitude','latitude',
         'price_per_hour','price_per_day', 'price_per_week','price_per_month','open_time','close_time','working_days','status'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function daysOff()
    {
        return $this->hasMany(DayOff::class);
    }
}
