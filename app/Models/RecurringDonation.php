<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringDonation extends Model
{
    protected $fillable = ['user_id','email','amount','currency','frequency','provider','provider_subscription_code','authorization_code','status','next_charge_at','cancelled_at'];
    protected $casts = ['amount' => 'decimal:2', 'next_charge_at' => 'datetime', 'cancelled_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
