<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller {
 public function index(){return view('admin.users.index',['users'=>User::with('roles')->latest()->paginate(25)]);}
 public function update(Request $r,User $user){$d=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|max:180','password'=>'nullable|string|min:8','is_admin'=>'nullable|boolean']);$d['is_admin']=$r->boolean('is_admin');if(empty($d['password']))unset($d['password']);else $d['password']=Hash::make($d['password']);$user->update($d);return back()->with('success','User updated.');}
 public function destroy(User $user){if($user->id===auth()->id())return back()->with('error','You cannot delete your own account.');$user->delete();return back()->with('success','User deleted.');}
}
