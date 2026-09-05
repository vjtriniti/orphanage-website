<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationReceipt;
use App\Models\PaymentTransaction;
use App\Services\PaystackGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentCheckoutController extends Controller
{
    public function initialize(Request $request)
    {
        $data = $request->validate([
            'donor_name' => ['required','string','max:120'], 'email' => ['required','email','max:160'],
            'amount' => ['required','numeric','min:100'], 'currency' => ['nullable','string','size:3'],
            'message' => ['nullable','string','max:1000'], 'purpose' => ['nullable','string','max:80'],
            'campaign' => ['nullable','string','max:160'], 'donation_type' => ['required','in:one_time,recurring'],
            'recurring_frequency' => ['nullable','required_if:donation_type,recurring','in:weekly,monthly,quarterly'], 'anonymous' => ['nullable','boolean'],
        ]);
        $data['currency'] = strtoupper($data['currency'] ?? 'NGN'); $data['payment_method']='paystack'; $data['status']='pending'; $data['anonymous']=(bool)($data['anonymous']??false);
        $reference = 'DON-'.now()->format('YmdHis').'-'.Str::upper(Str::random(8)); $data['reference']=$reference;
        $donation = Donation::create($data);
        try {
            $result = app(PaystackGateway::class)->initialize(['email'=>$donation->email,'amount'=>$donation->amount,'currency'=>$donation->currency,'reference'=>$reference,'callback_url'=>route('payments.callback')]);
        } catch (\Throwable $e) { $donation->update(['status'=>'failed']); return back()->withInput()->withErrors(['payment'=>'Payment could not be started. Please try again later.']); }
        PaymentTransaction::create(['donation_id'=>$donation->id,'provider'=>'paystack','reference'=>$result['reference']??$reference,'amount'=>$donation->amount,'currency'=>$donation->currency,'status'=>'pending','payload'=>$result['data']??[]]);
        if (empty($result['authorization_url'])) return back()->withErrors(['payment'=>'The payment provider did not return a checkout URL.']);
        return redirect()->away($result['authorization_url']);
    }

    public function callback(Request $request)
    {
        $reference=$request->string('reference')->toString(); abort_unless($reference,400,'Missing payment reference.');
        $result=app(PaystackGateway::class)->verify($reference); $transaction=PaymentTransaction::where('reference',$reference)->firstOrFail(); $status=$result['status']??'failed';
        $transaction->update(['status'=>$status,'payload'=>$result['data']??$transaction->payload]); $donation=$transaction->donation; $donation?->update(['status'=>$status==='success'?'completed':'failed']);
        if ($status==='success' && $donation) $this->issueReceipt($donation);
        return redirect()->route('donate')->with($status==='success'?'success':'error',$status==='success'?'Thank you. Your donation was completed successfully.':'The payment was not completed.');
    }

    private function issueReceipt(Donation $donation): void
    {
        DonationReceipt::firstOrCreate(['donation_id'=>$donation->id],['receipt_number'=>'REC-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),'issued_at'=>now()]);
        if ($user=\App\Models\User::where('email',$donation->email)->first()) {
            DB::table('notifications')->insert(['id'=>(string)Str::uuid(),'type'=>'donation.completed','notifiable_type'=>get_class($user),'notifiable_id'=>$user->id,'data'=>json_encode(['title'=>'Donation completed','message'=>'Your donation of '.$donation->currency.' '.number_format((float)$donation->amount,2).' was completed.']),'created_at'=>now(),'updated_at'=>now()]);
        }
    }
}
