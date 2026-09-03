<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; use Illuminate\Auth\Events\Verified;
class VerificationController extends Controller { public function notice(){return view('auth.verify-email');} public function verify(Request $request){$user=$request->user();if($user->hasVerifiedEmail())return redirect()->route('dashboard');if($user->markEmailAsVerified())event(new Verified($user));return redirect()->route('dashboard')->with('status','Email verified successfully.');} public function resend(Request $request){if($request->user()->hasVerifiedEmail())return redirect()->route('dashboard');$request->user()->sendEmailVerificationNotification();return back()->with('status','Verification email sent.');} }
