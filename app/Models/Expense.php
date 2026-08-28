<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model {
 protected $fillable=['category','description','amount','expense_date','reference'];
 protected $casts=['amount'=>'decimal:2','expense_date'=>'date'];
}
