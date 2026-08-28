<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Volunteer; use Illuminate\Http\Request;
class VolunteerController extends Controller {
 public function index(){return view('admin.volunteers.index',['volunteers'=>Volunteer::with('user')->latest()->paginate(20)]);}
 public function updateStatus(Request $r,Volunteer $volunteer){$d=$r->validate(['status'=>'required|in:pending,approved,rejected']);$volunteer->update($d);return back()->with('success','Volunteer status updated.');}
}
