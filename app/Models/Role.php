<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug',
    ];

    protected $hidden = ['pivot', "deleted_at"];
    protected $dates = ['deleted_at'];
    public function users()
    {
        // return $this->belongsToMany(Role::class, 'role_user'); you don't need to specify the name
        // because eloquent recognize the the pivot the table role_user convention
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
