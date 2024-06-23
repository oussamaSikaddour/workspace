<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name_fr','name_ar','description_fr', 'description_ar','quantity', 'price', 'status'];
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
