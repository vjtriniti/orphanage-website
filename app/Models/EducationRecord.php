<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EducationRecord extends Model { protected $fillable=['child_id','school','grade','academic_year','school_fees','attendance','results','achievements']; protected $casts=['school_fees'=>'decimal:2','attendance'=>'decimal:2']; public function child(){return $this->belongsTo(Child::class);} }
