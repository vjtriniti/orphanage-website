<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationReceipt extends Model
{
    protected $fillable = ['donation_id', 'receipt_number', 'issued_at'];
    protected $casts = ['issued_at' => 'datetime'];
    public function donation() { return $this->belongsTo(Donation::class); }
}
