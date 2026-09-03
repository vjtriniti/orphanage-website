<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\PaymentTransaction;
use App\Services\PaystackGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentCheckoutController extends Controller
{
    public function initialize(Request $request)
    {
        $data = $request->validate([
            'donor_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'amount' => ['required', 'numeric', 'min:100'],
            'currency' => ['nullable', 'string', 'size:3'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['currency'] = strtoupper($data['currency'] ?? 'NGN');
        $data['payment_method'] = 'paystack';
        $data['status'] = 'pending';

        $donation = Donation::create($data);
        $reference = 'DON-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(8));

        try {
            $result = app(PaystackGateway::class)->initialize([
                'email' => $donation->email,
                'amount' => $donation->amount,
                'currency' => $donation->currency,
                'reference' => $reference,
                'callback_url' => route('payments.callback'),
            ]);
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['payment' => 'Payment could not be started. Please try again later.']);
        }

        PaymentTransaction::create([
            'donation_id' => $donation->id,
            'provider' => 'paystack',
            'reference' => $result['reference'] ?? $reference,
            'amount' => $donation->amount,
            'currency' => $donation->currency,
            'status' => 'pending',
            'payload' => $result['data'] ?? [],
        ]);

        if (empty($result['authorization_url'])) {
            return back()->withErrors(['payment' => 'The payment provider did not return a checkout URL.']);
        }

        return redirect()->away($result['authorization_url']);
    }

    public function callback(Request $request)
    {
        $reference = $request->string('reference')->toString();
        abort_unless($reference, 400, 'Missing payment reference.');

        $result = app(PaystackGateway::class)->verify($reference);
        $transaction = PaymentTransaction::where('reference', $reference)->firstOrFail();
        $status = $result['status'] ?? 'failed';

        $transaction->update(['status' => $status, 'payload' => $result['data'] ?? $transaction->payload]);
        $transaction->donation?->update(['status' => $status === 'success' ? 'completed' : 'failed']);

        return redirect()->route('donate')->with(
            $status === 'success' ? 'success' : 'error',
            $status === 'success' ? 'Thank you. Your donation was completed successfully.' : 'The payment was not completed.'
        );
    }
}
