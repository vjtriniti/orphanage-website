<?php
namespace App\Models;
use App\Models\Concerns\Auditable; use Illuminate\Database\Eloquent\Model;
class Donation extends Model { use Auditable; protected $fillable=['donor_name','email','amount','currency','payment_method','status','message']; protected $casts=['amount'=>'decimal:2']; }
