<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationReceipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DonationReceiptController extends Controller
{
    public function download(Donation $donation): Response
    {
        abort_unless(auth()->check() && $donation->email === auth()->user()->email && $donation->status === 'completed', 403);

        $receipt = DonationReceipt::firstOrCreate(
            ['donation_id' => $donation->id],
            ['receipt_number' => 'REC-'.now()->format('Ymd').'-'.strtoupper(Str::random(8)), 'issued_at' => now()]
        );

        $pdf = Pdf::loadView('donor.receipt', compact('donation', 'receipt'));
        return $pdf->download($receipt->receipt_number.'.pdf');
    }
}
