<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['nullable', 'string', 'size:3'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['currency'] = strtoupper($validated['currency'] ?? 'NGN');
        $validated['status'] = 'pending';

        Donation::create($validated);

        return back()->with('success', 'Thank you. Your donation request has been received.');
    }
}
