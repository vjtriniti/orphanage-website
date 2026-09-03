<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request;
class EnsureTwoFactorVerified { public function handle(Request $request, Closure $next){$user=$request->user(); if(!$user || !$user->two_factor_enabled || $request->session()->get('two_factor_verified') || $request->routeIs('twofactor.challenge','twofactor.challenge.verify','logout')) return $next($request); return redirect()->route('twofactor.challenge');} }
