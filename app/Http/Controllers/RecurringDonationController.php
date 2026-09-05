<?php

namespace App\Http\Controllers;

use App\Models\RecurringDonation;
use Illuminate\Http\Request;

class RecurringDonationController extends Controller
{
    public function index()
    {
        $recurring = RecurringDonation::where('email', auth()->user()->email)->latest()->get();
        return view('donor.recurring', compact('recurring'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required','numeric','min:100'],
            'frequency' => ['required','in:weekly,monthly,quarterly'],
            'currency' => ['required','in:NGN,USD'],
        ]);

        RecurringDonation::create(array_merge($data, [
            'user_id' => auth()->id(),
            'email' => auth()->user()->email,
            'provider' => 'paystack',
            'status' => 'pending_setup',
            'next_charge_at' => now()->addMonth(),
        ]));

        return back()->with('success', 'Recurring donation preference saved. Complete payment authorization to activate automatic billing.');
    }

    public function cancel(RecurringDonation $recurringDonation)
    {
        abort_unless($recurringDonation->user_id === auth()->id(), 403);
        $recurringDonation->update(['status' => 'cancelled', 'cancelled_at' => now()]);
        return back()->with('success', 'Recurring donation cancelled.');
    }
}
