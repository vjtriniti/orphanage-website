<?php
namespace App\Http\Controllers;
use App\Models\RecurringDonation;
use App\Services\PaystackGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class RecurringDonationController extends Controller {
 public function index(){ $recurring=RecurringDonation::where('user_id',auth()->id())->latest()->get(); return view('donor.recurring',compact('recurring')); }
 public function store(Request $request){
  $data=$request->validate(['amount'=>['required','numeric','min:100'],'frequency'=>['required','in:weekly,monthly,quarterly'],'currency'=>['required','in:NGN,USD']]);
  $user=auth()->user(); $gateway=app(PaystackGateway::class);
  try {
   $customer=$gateway->fetchCustomer($user->email);
  } catch(\Throwable $e) { $customer=null; }
  if(!$customer || empty($customer['customer_code'])) return back()->withErrors(['recurring'=>'Paystack could not find your customer profile. Make a small one-time payment first, then enable recurring donations.']);
  try {
   $plan=$gateway->createPlan('Hope & Care '.$data['frequency'].' donation '.Str::upper(Str::random(5)),(float)$data['amount'],$data['frequency'],$data['currency']);
   $subscription=$gateway->createSubscription($customer['customer_code'],$plan['plan_code']);
   RecurringDonation::create(['user_id'=>$user->id,'email'=>$user->email,'amount'=>$data['amount'],'currency'=>$data['currency'],'frequency'=>$data['frequency'],'provider'=>'paystack','provider_subscription_code'=>$subscription['subscription_code']??null,'authorization_code'=>$subscription['authorization']??null,'status'=>$subscription['status']??'active','next_charge_at'=>!empty($subscription['next_payment_date'])?$subscription['next_payment_date']:now()->addMonth()]);
  } catch(\Throwable $e) { return back()->withInput()->withErrors(['recurring'=>'Recurring payment setup could not be completed. Please try again later.']); }
  return back()->with('success','Recurring donation activated successfully.');
 }
 public function cancel(RecurringDonation $recurringDonation){ abort_unless($recurringDonation->user_id===auth()->id(),403); if($recurringDonation->provider==='paystack' && $recurringDonation->provider_subscription_code && $recurringDonation->authorization_code){ try{ app(PaystackGateway::class)->disableSubscription($recurringDonation->provider_subscription_code,$recurringDonation->authorization_code); }catch(\Throwable $e){ return back()->withErrors(['recurring'=>'Paystack could not cancel the subscription. Please try again.']); } } $recurringDonation->update(['status'=>'cancelled','cancelled_at'=>now()]); return back()->with('success','Recurring donation cancelled.'); }
}
