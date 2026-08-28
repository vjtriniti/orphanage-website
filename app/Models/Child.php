<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Child extends Model {
 protected $fillable=['public_code','age','gender','education_status','interests','needs','success_story','active'];
 protected $casts=['active'=>'boolean'];
}
