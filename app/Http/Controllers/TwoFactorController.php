<?php
namespace App\Http\Controllers;

use App\Services\TotpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TwoFactorController extends Controller
{
    public function __construct(private TotpService $totp) {}
    public function setup(Request $request) { $user=$request->user(); $secret=$user->two_factor_secret ? Crypt::decryptString($user->two_factor_secret) : $this->totp->generateSecret(); if(!$user->two_factor_secret){$user->forceFill(['two_factor_secret'=>Crypt::encryptString($secret)])->save();} return view('auth.two-factor-setup',['secret'=>$secret,'uri'=>$this->totp->uri($secret,$user->email)]); }
    public function confirm(Request $request) { $request->validate(['code'=>'required|digits:6']); $user=$request->user(); abort_unless($user->two_factor_secret,422); $secret=Crypt::decryptString($user->two_factor_secret); if(!$this->totp->verify($secret,$request->code)) return back()->withErrors(['code'=>'The verification code is invalid or expired.']); $user->forceFill(['two_factor_enabled'=>true])->save(); $request->session()->put('two_factor_verified',true); return redirect()->route('dashboard')->with('success','Two-factor authentication is now enabled.'); }
    public function challenge(Request $request) { if(!$request->user()->two_factor_enabled || $request->session()->get('two_factor_verified')) return redirect()->route('dashboard'); return view('auth.two-factor-challenge'); }
    public function verify(Request $request) { $request->validate(['code'=>'required|digits:6']); $user=$request->user(); $secret=Crypt::decryptString($user->two_factor_secret); if(!$this->totp->verify($secret,$request->code)) return back()->withErrors(['code'=>'Invalid or expired authentication code.']); $request->session()->put('two_factor_verified',true); return redirect()->intended(route('dashboard')); }
    public function disable(Request $request) { $request->validate(['code'=>'required|digits:6']); $user=$request->user(); $secret=Crypt::decryptString($user->two_factor_secret); if(!$this->totp->verify($secret,$request->code)) return back()->withErrors(['code'=>'Invalid authentication code.']); $user->forceFill(['two_factor_enabled'=>false,'two_factor_secret'=>null])->save(); $request->session()->put('two_factor_verified',true); return back()->with('success','Two-factor authentication disabled.'); }
}
