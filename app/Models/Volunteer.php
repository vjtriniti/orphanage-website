<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'skills', 'experience',
        'availability', 'emergency_contact', 'status', 'approved_at',
    ];

    protected $casts = ['approved_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function hours() { return $this->hasMany(VolunteerHour::class); }
}
