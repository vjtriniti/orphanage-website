<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request;
class EnsurePermission { public function handle(Request $request, Closure $next, string $permission){$user=$request->user(); abort_unless($user && $user->hasPermission($permission),403); return $next($request);} }
