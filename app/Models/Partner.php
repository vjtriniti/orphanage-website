<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['name', 'logo', 'website', 'description', 'published', 'sort_order'];

    protected $casts = ['published' => 'boolean'];
}
