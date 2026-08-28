<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Volunteer extends Model {
 protected $fillable=['user_id','skills','experience','availability','emergency_contact','status'];
 public function user(){return $this->belongsTo(User::class);}
}
