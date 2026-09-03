<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request;
class EnsureTwoFactorVerified { public function handle(Request $request, Closure $next){$user=$request->user(); if($user && $user->two_factor_enabled && !$request->session()->get('two_factor_verified') && $request->routeIs('twofactor.challenge','twofactor.challenge.verify')) return $next($request); if($user && $user->two_factor_enabled && !$request->session()->get('two_factor_verified')) return redirect()->route('twofactor.challenge'); return $next($request);} }
