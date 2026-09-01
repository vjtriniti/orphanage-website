<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Child;
use App\Models\Donation;
use App\Models\Expense;
use App\Models\Volunteer;
use App\Models\AuditLog;
class DashboardController extends Controller
{
    public function index()
    {
        $stats=[
            'children'=>Child::where('active',true)->count(),
            'donors'=>Donation::distinct('email')->count('email'),
            'donations'=>Donation::where('status','completed')->sum('amount'),
            'pending_donations'=>Donation::where('status','pending')->count(),
            'volunteers'=>class_exists(Volunteer::class)?Volunteer::where('status','approved')->count():0,
            'campaigns'=>Campaign::where('status','active')->count(),
            'expenses'=>Expense::sum('amount'),
        ];
        $chartLabels=[];$chartData=[];
        for($i=5;$i>=0;$i--){$date=now()->subMonths($i);$chartLabels[]=$date->format('M');$chartData[]=Donation::where('status','completed')->whereYear('created_at',$date->year)->whereMonth('created_at',$date->month)->sum('amount');}
        $recentActivity=class_exists(AuditLog::class)?AuditLog::latest()->limit(6)->get():collect();
        $recentDonations=Donation::latest()->limit(5)->get();
        $campaigns=Campaign::where('status','active')->orderByDesc('current_amount')->limit(4)->get();
        return view('admin.dashboard',compact('stats','chartLabels','chartData','recentActivity','recentDonations','campaigns'));
    }
}
