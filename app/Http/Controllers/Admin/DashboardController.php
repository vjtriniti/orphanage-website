<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Campaign;
use App\Models\Child;
use App\Models\Donation;
use App\Models\Expense;
use App\Models\InventoryItem;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $completed = Donation::where('status', 'completed');

        $stats = [
            'children' => Child::where('active', true)->count(),
            'donors' => (clone $completed)->whereNotNull('email')->distinct('email')->count('email'),
            'donations' => (float) (clone $completed)->sum('amount'),
            'pending_donations' => Donation::where('status', 'pending')->count(),
            'volunteers' => Volunteer::whereIn('status', ['approved', 'active'])->count(),
            'pending_volunteers' => Volunteer::where('status', 'pending')->count(),
            'campaigns' => Campaign::where('status', 'active')->count(),
            'expenses' => (float) Expense::sum('amount'),
            'low_stock' => InventoryItem::whereColumn('quantity', '<=', 'reorder_level')->count(),
        ];
        $stats['net'] = $stats['donations'] - $stats['expenses'];

        $chartLabels = [];
        $chartDonations = [];
        $chartExpenses = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->format('M');
            $chartDonations[] = (float) (clone $completed)->whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->sum('amount');
            $chartExpenses[] = (float) Expense::whereYear('expense_date', $date->year)->whereMonth('expense_date', $date->month)->sum('amount');
        }

        // Keep the original chart variable available for existing dashboard markup.
        $chartData = $chartDonations;

        $recentActivity = class_exists(AuditLog::class) ? AuditLog::latest()->limit(7)->get() : collect();
        $recentDonationsQuery = Donation::latest();
        if ($search !== '') {
            $recentDonationsQuery->where(function ($query) use ($search) {
                $query->where('donor_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }
        $recentDonations = $recentDonationsQuery->limit(6)->get();

        $campaigns = Campaign::where('status', 'active')->orderByDesc('current_amount')->limit(4)->get();
        $lowStockItems = InventoryItem::whereColumn('quantity', '<=', 'reorder_level')->orderBy('quantity')->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'chartLabels', 'chartData', 'chartDonations', 'chartExpenses', 'recentActivity',
            'recentDonations', 'campaigns', 'lowStockItems', 'search'
        ));
    }
}
