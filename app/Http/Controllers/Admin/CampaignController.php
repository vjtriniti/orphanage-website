<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Campaign; use Illuminate\Http\Request; use Illuminate\Support\Str;
class CampaignController extends Controller {
 public function index(){return view('admin.campaigns.index',['campaigns'=>Campaign::latest()->paginate(15)]);}
 public function store(Request $r){$d=$r->validate(['title'=>'required|string|max:180','description'=>'required|string','target_amount'=>'required|numeric|min:1','start_date'=>'nullable|date','end_date'=>'nullable|date|after_or_equal:start_date','status'=>'nullable|in:draft,active,completed,closed']); $d['slug']=Str::slug($d['title']).'-'.Str::lower(Str::random(5)); Campaign::create($d); return back()->with('success','Campaign created.');}
 public function update(Request $r,Campaign $campaign){$d=$r->validate(['title'=>'required|string|max:180','description'=>'required|string','target_amount'=>'required|numeric|min:1','start_date'=>'nullable|date','end_date'=>'nullable|date|after_or_equal:start_date','status'=>'required|in:draft,active,completed,closed']);$campaign->update($d);return back()->with('success','Campaign updated.');}
 public function destroy(Campaign $campaign){$campaign->update(['status'=>'closed']);return back()->with('success','Campaign closed.');}
}
