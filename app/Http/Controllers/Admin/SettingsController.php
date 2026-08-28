<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Setting; use Illuminate\Http\Request;
class SettingsController extends Controller { public function edit(){return view('admin.settings.edit',['settings'=>Setting::pluck('value','key')]);} public function update(Request $r){$data=$r->validate(['organization_name'=>'nullable|string|max:180','email'=>'nullable|email|max:180','phone'=>'nullable|string|max:50','address'=>'nullable|string|max:500','currency'=>'nullable|string|max:10']);foreach($data as $key=>$value)Setting::updateOrCreate(['key'=>$key],['value'=>$value]);return back()->with('success','Settings saved.');} }
