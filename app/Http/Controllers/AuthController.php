<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function showLogin(){ return view('auth.login'); }

    public function login(Request $request)
    {
        $credentials=$request->validate(['email'=>'required|email','password'=>'required|string']);
        if(!Auth::attempt($credentials,$request->boolean('remember'))){
            return back()->withErrors(['email'=>'Invalid email or password.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user=Auth::user();
        $request->session()->put('two_factor_verified', !$user->two_factor_enabled);

        if (($user->is_admin ?? false) || $user->roles()->exists()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister(){ return view('auth.register'); }

    public function register(Request $request){
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|max:255|unique:users','password'=>'required|string|min:8|confirmed']);
        $user=User::create($data);
        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('two_factor_verified',true);
        return redirect()->route('dashboard')->with('success','Account created. Please verify your email.');
    }

    public function logout(Request $request){Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return redirect()->route('home');}
    public function showForgot(){return view('auth.forgot-password');}
    public function sendReset(Request $request){$data=$request->validate(['email'=>'required|email']);$status=Password::sendResetLink($data);return $status===Password::RESET_LINK_SENT?back()->with('status','Password reset link sent.'):back()->withErrors(['email'=>__($status)]);}
    public function showReset(Request $request,string $token){return view('auth.reset-password',['token'=>$token,'email'=>$request->email]);}
    public function reset(Request $request){$data=$request->validate(['token'=>'required','email'=>'required|email','password'=>'required|min:8|confirmed']);$status=Password::reset($data,function(User $user,string $password){$user->forceFill(['password'=>$password,'remember_token'=>Str::random(60)])->save();});return $status===Password::PASSWORD_RESET?redirect()->route('login')->with('status','Password reset successfully.'):back()->withErrors(['email'=>__($status)]);}
}
