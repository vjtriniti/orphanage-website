<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Permission; use App\Models\Role; use Illuminate\Http\Request;
class RoleController extends Controller
{
 public function index(){return view('admin.roles.index',['roles'=>Role::with('permissions')->orderBy('name')->get(),'permissions'=>Permission::orderBy('name')->get()]);}
 public function store(Request $request){$data=$request->validate(['name'=>'required|string|max:80|unique:roles,name','label'=>'nullable|string|max:120','permissions'=>'array','permissions.*'=>'integer|exists:permissions,id']);$role=Role::create(['name'=>$data['name'],'label'=>$data['label']??$data['name']]);$role->permissions()->sync($data['permissions']??[]);return back()->with('success','Role created successfully.');}
 public function update(Request $request, Role $role){$data=$request->validate(['label'=>'nullable|string|max:120','permissions'=>'array','permissions.*'=>'integer|exists:permissions,id']);$role->update(['label'=>$data['label']??$role->name]);$role->permissions()->sync($data['permissions']??[]);return back()->with('success','Role permissions updated.');}
 public function destroy(Role $role){abort_if($role->name==='super-admin',403,'The super-admin role cannot be deleted.');$role->permissions()->detach();$role->users()->detach();$role->delete();return back()->with('success','Role deleted.');}
}
