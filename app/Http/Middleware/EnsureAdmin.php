<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        abort_unless($user && (($user->is_admin ?? false) || $user->roles()->exists()), 403);

        return $next($request);
    }
}
