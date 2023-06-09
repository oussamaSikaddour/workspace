<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'workspace_id', 'start_date', 'end_date', 'capacity', 'status'
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
