<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    use HasFactory;
    protected $fillable = [
        'workspace_id', 'day_of_week', 'open_time', 'close_time'
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
