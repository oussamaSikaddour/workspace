<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "pivot",
        'password',
        'remember_token',
        "deleted_at"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    public function roles()
    {
        // return $this->belongsToMany(Role::class, 'role_user'); you don't need to specify the name
        // because eloquent recognize the the pivot the table role_user convention
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
    public function personnelInfo(): HasOne
    {
        return $this->hasOne(PersonnelInfo::class);
    }
    public function occupation(): HasOne
    {
        return $this->hasOne(Occupation::class);
    }

    public function education(): HasOne
    {
        return $this->hasOne(Education::class);
    }
    public function messages(): hasMany
    {
        return $this->hasMany(Message::class);
    }

    public function bookings(): hasMany
    {
        return $this->hasMany(Booking::class);
    }
}
