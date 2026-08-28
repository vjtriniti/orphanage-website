<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Child;
use App\Models\Donation;
use App\Models\Expense;
use App\Models\Volunteer;
class DashboardController extends Controller {
 public function index(){
  $stats=[
   'children'=>Child::where('active',true)->count(),
   'donors'=>Donation::distinct('email')->count('email'),
   'donations'=>Donation::where('status','completed')->sum('amount'),
   'pending_donations'=>Donation::where('status','pending')->count(),
   'volunteers'=>class_exists(Volunteer::class)?Volunteer::where('status','approved')->count():0,
   'campaigns'=>Campaign::where('status','active')->count(),
   'expenses'=>Expense::sum('amount'),
  ];
  return view('admin.dashboard',compact('stats'));
 }
}
