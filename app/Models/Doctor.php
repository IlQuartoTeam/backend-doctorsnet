<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Review;
use App\Models\Subscription;
use App\Models\Specialization;

class Doctor extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function experiences(){
        $this->hasMany(Experience::class);
    }

    public function messages(){
        $this->hasMany(Message::class);
    }

    public function reviews(){
        $this->hasMany(Review::class);
    }

    public function subscription(){
        $this->belongsToMany(Subscription::class);
    }

    public function specializations(){
        $this->belongsToMany(Specialization::class);
    }
}
