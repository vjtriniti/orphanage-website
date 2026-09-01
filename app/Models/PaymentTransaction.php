<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PaymentTransaction extends Model { protected $fillable=['donation_id','provider','reference','amount','currency','status','payload']; protected $casts=['amount'=>'decimal:2','payload'=>'array']; public function donation(){return $this->belongsTo(Donation::class);} }
