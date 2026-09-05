<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class InventoryController extends Controller {
 public function index(){return view('admin.inventory.index',['items'=>InventoryItem::with('category')->orderBy('name')->paginate(25),'categories'=>InventoryCategory::orderBy('name')->get()]);}
 public function store(Request $r){$d=$r->validate(['inventory_category_id'=>'nullable|exists:inventory_categories,id','name'=>'required|string|max:180','unit'=>'required|string|max:40','quantity'=>'required|numeric|min:0','reorder_level'=>'required|numeric|min:0','supplier'=>'nullable|string|max:180']);InventoryItem::create($d);return back()->with('success','Inventory item created.');}
 public function update(Request $r,InventoryItem $item){$d=$r->validate(['inventory_category_id'=>'nullable|exists:inventory_categories,id','name'=>'required|string|max:180','unit'=>'required|string|max:40','reorder_level'=>'required|numeric|min:0','supplier'=>'nullable|string|max:180']);$item->update($d);return back()->with('success','Inventory item updated.');}
 public function destroy(InventoryItem $item){$item->delete();return back()->with('success','Inventory item deleted.');}
 public function move(Request $r,InventoryItem $item){$d=$r->validate(['type'=>'required|in:in,out,adjustment','quantity'=>'required|numeric|min:0.01','reason'=>'nullable|string|max:255']);DB::transaction(function()use($item,$d){$old=(float)$item->quantity;$qty=(float)$d['quantity'];if($d['type']==='out'&&$qty>$old)abort(422,'Insufficient stock.');$new=$d['type']==='in'?$old+$qty:($d['type']==='out'?$old-$qty:$qty);$item->update(['quantity'=>$new]);$item->transactions()->create(['type'=>$d['type'],'quantity'=>$qty,'reason'=>$d['reason']??null,'user_id'=>auth()->id()]);});return back()->with('success','Stock movement recorded.');}
}
