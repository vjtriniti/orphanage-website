<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\RecurringDonation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $email = $user->email;

        $donations = Donation::where('email', $email)->latest()->paginate(10);

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

        $recurringDonation = RecurringDonation::where(function ($query) use ($user, $email) {
            $query->where('user_id', $user->id)->orWhere('email', $email);
        })->where('status', 'active')->latest()->first();

        $unreadNotifications = DB::table('notifications')
            ->where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->whereNull('read_at')
            ->count();

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
        })->values();

        $chartMax = max((float) $months->max('amount'), 1);
        $chartPoints = $months->map(function ($month, $index) use ($chartMax) {
            $x = 42 + ($index * 94);
            $y = 190 - (($month['amount'] / $chartMax) * 145);
            return round($x, 1) . ',' . round($y, 1);
        })->implode(' ');

        $recentActivity = $donations->getCollection()->take(4);

        return view('donor.dashboard', compact(
            'donations',
            'total',
            'count',
            'completedCount',
            'yearTotal',
            'activeCampaigns',
            'recurringDonation',
            'unreadNotifications',
            'recentActivity',
            'months',
            'chartMax',
            'chartPoints'
        ));
    }
}
