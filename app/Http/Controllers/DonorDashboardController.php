<?php
namespace App\Http\Controllers;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
class DonorDashboardController extends Controller {
 public function index(){
  $email=Auth::user()->email;
  $donations=Donation::where('email',$email)->latest()->paginate(10);
  $total=Donation::where('email',$email)->where('status','completed')->sum('amount');
  $count=Donation::where('email',$email)->count();
  return view('donor.dashboard',compact('donations','total','count'));
 }
}
