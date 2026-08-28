<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\InventoryItem; use Illuminate\Http\Request; use Illuminate\Support\Facades\DB;
class InventoryController extends Controller {
 public function index(){return view('admin.inventory.index',['items'=>InventoryItem::with('category')->orderBy('name')->paginate(25)]);}
 public function move(Request $r,InventoryItem $item){$d=$r->validate(['type'=>'required|in:in,out,adjustment','quantity'=>'required|numeric|min:0.01','reason'=>'nullable|string|max:255']);DB::transaction(function() use($item,$d){$old=(float)$item->quantity;$qty=(float)$d['quantity'];$new=$d['type']==='in'?$old+$qty:($d['type']==='out'?max(0,$old-$qty):$qty);$item->update(['quantity'=>$new]);$item->transactions()->create(['type'=>$d['type'],'quantity'=>$qty,'reason'=>$d['reason']??null,'user_id'=>auth()->id()]);});return back()->with('success','Stock movement recorded.');}
}
