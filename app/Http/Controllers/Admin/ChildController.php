<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Child;
use Illuminate\Http\Request;
class ChildController extends Controller {
 public function index(){return view('admin.children.index',['children'=>Child::latest()->paginate(20)]);}
 public function store(Request $r){$data=$r->validate(['public_code'=>'required|string|max:50|unique:children,public_code','age'=>'nullable|integer|min:0|max:18','gender'=>'nullable|in:male,female,other','education_status'=>'nullable|string|max:120','interests'=>'nullable|string','needs'=>'nullable|string','success_story'=>'nullable|string','active'=>'nullable|boolean']); Child::create($data);return back()->with('success','Child profile created.');}
 public function destroy(Child $child){$child->update(['active'=>false]);return back()->with('success','Child profile archived.');}
}
