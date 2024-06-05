<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'days_available',
        'hour_available_from',
        'hour_available_to',
        'slot_available_in_minutes',
        'capacity',   
    ];
    
    public function bookings(){
        return $this->hasMany(Booking::class, 'classroom_id', 'id');
    }    
}
