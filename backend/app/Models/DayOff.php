<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{

    use HasFactory;
    protected $table = 'days_off';
    protected $fillable = [
        'workspace_id', 'days_off_start', 'days_off_end'
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
