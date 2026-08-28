<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest()->paginate(20);

        return view('admin.donations.index', compact('donations'));
    }

    public function updateStatus(Donation $donation)
    {
        request()->validate([
            'status' => ['required', 'in:pending,completed,failed'],
        ]);

        $donation->update(['status' => request('status')]);

        return back()->with('success', 'Donation status updated.');
    }
}
