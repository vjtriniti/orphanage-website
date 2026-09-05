<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use Auditable;

    protected $fillable = [
        'reference','donor_name','email','amount','currency','payment_method','status',
        'message','purpose','campaign','donation_type','recurring_frequency','anonymous',
    ];

    protected $casts = ['amount' => 'decimal:2', 'anonymous' => 'boolean'];

    public function receipt() { return $this->hasOne(DonationReceipt::class); }
}
