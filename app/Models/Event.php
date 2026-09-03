<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Auditable;

    protected $fillable=['title','description','starts_at','ends_at','location','image','published'];
    protected $casts=['starts_at'=>'datetime','ends_at'=>'datetime','published'=>'boolean'];
}
