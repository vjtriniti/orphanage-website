<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Expense; use Illuminate\Http\Request;
class ExpenseController extends Controller {
 public function index(){return view('admin.expenses.index',['expenses'=>Expense::latest('expense_date')->paginate(20)]);}
 public function store(Request $r){$d=$r->validate(['category'=>'required|string|max:100','description'=>'required|string|max:500','amount'=>'required|numeric|min:0.01','expense_date'=>'required|date','reference'=>'nullable|string|max:100']);Expense::create($d);return back()->with('success','Expense recorded.');}
 public function update(Request $r,Expense $expense){$d=$r->validate(['category'=>'required|string|max:100','description'=>'required|string|max:500','amount'=>'required|numeric|min:0.01','expense_date'=>'required|date','reference'=>'nullable|string|max:100']);$expense->update($d);return back()->with('success','Expense updated.');}
 public function destroy(Expense $expense){$expense->delete();return back()->with('success','Expense removed.');}
}
