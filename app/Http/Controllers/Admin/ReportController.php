<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Donation; use App\Models\Expense; use Illuminate\Http\Request;
class ReportController extends Controller { public function index(Request $r){$from=$r->date('from');$to=$r->date('to');$donations=Donation::where('status','completed')->when($from,fn($q)=>$q->whereDate('created_at','>=',$from))->when($to,fn($q)=>$q->whereDate('created_at','<=',$to))->sum('amount');$expenses=Expense::when($from,fn($q)=>$q->whereDate('expense_date','>=',$from))->when($to,fn($q)=>$q->whereDate('expense_date','<=',$to))->sum('amount');return view('admin.reports.index',compact('donations','expenses','from','to'));} }
