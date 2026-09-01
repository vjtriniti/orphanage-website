<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VolunteerHour extends Model { protected $fillable=['volunteer_id','activity','started_at','ended_at','hours','notes']; protected $casts=['started_at'=>'datetime','ended_at'=>'datetime','hours'=>'decimal:2']; public function volunteer(){return $this->belongsTo(Volunteer::class);} }
