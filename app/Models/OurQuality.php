<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class OurQuality extends Model
{
    use HasFactory;
    protected $fillable = ['name_fr','name_ar','status'];
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
