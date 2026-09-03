<?php
namespace App\Models;
use App\Models\Concerns\Auditable; use Illuminate\Database\Eloquent\Model;
class Expense extends Model { use Auditable; protected $fillable=['category','description','amount','expense_date','reference']; protected $casts=['amount'=>'decimal:2','expense_date'=>'date']; }
