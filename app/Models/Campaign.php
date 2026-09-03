<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use Auditable;

    protected $fillable = ['title','slug','description','target_amount','current_amount','start_date','end_date','banner','status'];
    protected $casts = ['target_amount'=>'decimal:2','current_amount'=>'decimal:2','start_date'=>'date','end_date'=>'date'];
}
