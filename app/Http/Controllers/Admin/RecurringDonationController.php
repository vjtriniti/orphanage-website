<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecurringDonation;

class RecurringDonationController extends Controller
{
    public function index()
    {
        $recurring = RecurringDonation::latest()->paginate(20);
        return view('admin.donations.recurring', compact('recurring'));
    }

    public function cancel(RecurringDonation $recurringDonation)
    {
        $recurringDonation->update(['status' => 'cancelled', 'cancelled_at' => now()]);
        return back()->with('success', 'Recurring donation cancelled.');
    }
}
