<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MedicalRecord extends Model { protected $fillable=['child_id','record_date','record_type','notes','expense']; protected $casts=['record_date'=>'date','expense'=>'decimal:2']; public function child(){return $this->belongsTo(Child::class);} }
