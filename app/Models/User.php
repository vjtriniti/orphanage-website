<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = ['name','email','password','is_admin','two_factor_enabled','two_factor_secret'];
    protected $hidden = ['password','remember_token','two_factor_secret'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed','is_admin'=>'boolean','two_factor_enabled'=>'boolean']; }
}
