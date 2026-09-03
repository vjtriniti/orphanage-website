<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\PaymentTransaction;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $raw = $request->getContent();
        $secret = (string) env('PAYSTACK_SECRET_KEY', '');
        $signature = $request->header('X-Paystack-Signature') ?: $request->header('X-Payment-Signature');

        abort_unless($secret && $signature && hash_equals(hash_hmac('sha512', $raw, $secret), $signature)
            || ($request->header('X-Payment-Signature') && env('PAYMENT_WEBHOOK_SECRET') && hash_equals(hash_hmac('sha256', $raw, env('PAYMENT_WEBHOOK_SECRET')), $request->header('X-Payment-Signature'))), 401);

        $payload = $request->json()->all();
        $provider = $payload['provider'] ?? 'paystack';
        $reference = $payload['data']['reference'] ?? $payload['reference'] ?? null;
        $status = $payload['data']['status'] ?? $payload['status'] ?? null;

        abort_unless($reference && $status, 422, 'Invalid payment webhook payload.');

        $transaction = PaymentTransaction::updateOrCreate(
            ['reference' => $reference],
            [
                'provider' => $provider,
                'status' => $status,
                'amount' => isset($payload['data']['amount']) ? ((float) $payload['data']['amount'] / 100) : ($payload['amount'] ?? 0),
                'currency' => $payload['data']['currency'] ?? $payload['currency'] ?? 'NGN',
                'payload' => $payload,
            ]
        );

        $donation = $transaction->donation;
        if ($donation && in_array($status, ['success', 'completed'], true)) {
            $donation->update(['status' => 'completed']);
        } elseif ($donation && in_array($status, ['failed', 'abandoned'], true)) {
            $donation->update(['status' => 'failed']);
        }

        AuditLogger::record('payment.webhook', 'Payment webhook processed', $transaction);

        return response()->json(['received' => true]);
    }
}
