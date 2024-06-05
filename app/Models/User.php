<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const INVALIDATE_TOKEN_IF_INACTIVE_IN_MINUTES = 120;

    protected $fillable = [
        'email',
        'password',
        'active',
        'balance',
        'last_activity',
        'created_at',
        'updated_at',   
    ];

    protected $hidden = [
        'password',
    ];
    
    public function bookings(){
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }    
}
