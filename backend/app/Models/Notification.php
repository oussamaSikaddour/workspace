<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "user_id",
        "message",
        "state",
        "active",
        "target"
    ];
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
