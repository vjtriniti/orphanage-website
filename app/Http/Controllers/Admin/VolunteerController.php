<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class VolunteerController extends Controller {
 public function index(){return view('admin.volunteers.index',['volunteers'=>Volunteer::with('user')->latest()->paginate(20)]);}
 public function update(Request $r,Volunteer $volunteer){$d=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|max:180','phone'=>'nullable|string|max:40','skills'=>'nullable|string','experience'=>'nullable|string','availability'=>'nullable|string','emergency_contact'=>'nullable|string|max:180','status'=>'required|in:pending,approved,rejected']);if($d['status']==='approved'&&!$volunteer->approved_at)$d['approved_at']=Carbon::now();if($d['status']!=='approved')$d['approved_at']=null;$volunteer->update($d);return back()->with('success','Volunteer updated.');}
 public function updateStatus(Request $r,Volunteer $volunteer){$r->validate(['status'=>'required|in:pending,approved,rejected']);$volunteer->update(['status'=>$r->status,'approved_at'=>$r->status==='approved'?Carbon::now():null]);return back()->with('success','Volunteer status updated.');}
 public function destroy(Volunteer $volunteer){$volunteer->delete();return back()->with('success','Volunteer deleted.');}
}
