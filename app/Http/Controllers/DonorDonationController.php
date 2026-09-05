<?php

namespace App\Http\Controllers;

use App\Models\Donation;

class DonorDonationController extends Controller
{
    public function index()
    {
        $donations = Donation::where('email', auth()->user()->email)->latest()->paginate(20);
        return view('donor.donations', compact('donations'));
    }
}
