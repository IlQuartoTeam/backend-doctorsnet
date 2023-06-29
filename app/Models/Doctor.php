<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function experiences(){
        $this->belongsToMany(Experience::class);
    }

    public function messages(){
        $this->belongsToMany(Message::class);
    }

    public function reviews(){
        $this->belongsToMany(Review::class);
    }
}
