<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
class DonationController extends Controller
{
 public function index(){return view('admin.donations.index',['donations'=>Donation::latest()->paginate(20)]);}
 public function update(Request $r, Donation $donation){$d=$r->validate(['donor_name'=>'required|string|max:120','email'=>'required|email|max:180','amount'=>'required|numeric|min:1','currency'=>'required|string|size:3','purpose'=>'nullable|string|max:120','campaign'=>'nullable|string|max:180','payment_method'=>'required|string|max:50','status'=>'required|in:pending,completed,failed','donation_type'=>'required|in:one_time,recurring','recurring_frequency'=>'nullable|in:weekly,monthly,quarterly,yearly','anonymous'=>'nullable|boolean','message'=>'nullable|string|max:2000']);$d['anonymous']=$r->boolean('anonymous');$donation->update($d);return back()->with('success','Donation updated.');}
 public function updateStatus(Request $r, Donation $donation){$r->validate(['status'=>'required|in:pending,completed,failed']);$donation->update(['status'=>$r->status]);return back()->with('success','Donation status updated.');}
 public function destroy(Donation $donation){$donation->delete();return back()->with('success','Donation deleted.');}
}
