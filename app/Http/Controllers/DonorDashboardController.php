<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DonorDashboardController extends Controller
{
    public function index()
    {
        $email = Auth::user()->email;

        $donations = Donation::where('email', $email)
            ->latest()
            ->paginate(10);

        $total = Donation::where('email', $email)
            ->where('status', 'completed')
            ->sum('amount');

        $count = Donation::where('email', $email)->count();

        $completedCount = Donation::where('email', $email)
            ->where('status', 'completed')
            ->count();

        $yearTotal = Donation::where('email', $email)
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $activeCampaigns = Campaign::where('status', 'active')->count();

        $months = collect(range(5, 0))->map(function ($offset) use ($email) {
            $date = Carbon::now()->subMonths($offset);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            return [
                'label' => $date->format('M'),
                'amount' => (float) Donation::where('email', $email)
                    ->where('status', 'completed')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('amount'),
            ];
        });

        $chartMax = max((float) $months->max('amount'), 1);

        return view('donor.dashboard', compact(
            'donations',
            'total',
            'count',
            'completedCount',
            'yearTotal',
            'activeCampaigns',
            'months',
            'chartMax'
        ));
    }
}
