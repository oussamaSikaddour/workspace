<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;
    protected $table="heros";

    protected $fillable = [
        "title_ar",
        "title_fr",
        "sub_title_ar",
        "sub_title_fr",
    ];
}
