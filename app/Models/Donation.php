<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_name',
        'email',
        'amount',
        'currency',
        'payment_method',
        'status',
        'message',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
