<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use Auditable;

    protected $fillable=['public_code','age','gender','education_status','interests','needs','success_story','active'];
    protected $casts=['active'=>'boolean'];
    public function educationRecords(){return $this->hasMany(EducationRecord::class);}
    public function medicalRecords(){return $this->hasMany(MedicalRecord::class);}
}
