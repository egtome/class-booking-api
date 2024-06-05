<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'classroom_id',
        'start_at',
        'end_at', 
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
   
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }    
}
