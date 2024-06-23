<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
    use HasFactory;

    protected $table = 'day_offs';
    protected $fillable = [
   'classroom_id', 'days_off_start', 'days_off_end'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
