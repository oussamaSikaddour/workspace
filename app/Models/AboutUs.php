<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AboutUs extends Model
{
    use HasFactory;
    protected $table="about_us";

    protected $fillable = [
       "title_fr",
       "title_ar",
       "description_fr",
       "description_ar",
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
