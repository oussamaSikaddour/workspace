<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'location', 'capacity', 'price_per_hour'
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function daysOff()
    {
        return $this->hasMany(DayOff::class);
    }

    public function openingHours()
    {
        return $this->hasMany(OpeningHour::class);
    }
}
