<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class PaystackGateway implements PaymentGateway
{
 private string $secret; private string $base='https://api.paystack.co';
 public function __construct(){ $this->secret=(string)config('services.paystack.secret',env('PAYSTACK_SECRET_KEY','')); }
 public function initialize(array $payload): array { $response=Http::withToken($this->secret)->post($this->base.'/transaction/initialize',['email'=>$payload['email'],'amount'=>(int)round($payload['amount']*100),'currency'=>$payload['currency']??'NGN','reference'=>$payload['reference']??null,'callback_url'=>$payload['callback_url']??null]); if(!$response->successful()) throw new \RuntimeException('Unable to initialize payment.'); $data=$response->json('data',[]); return ['success'=>(bool)$response->json('status'),'reference'=>$data['reference']??null,'authorization_url'=>$data['authorization_url']??null,'data'=>$data]; }
 public function verify(string $reference): array { $response=Http::withToken($this->secret)->get($this->base.'/transaction/verify/'.urlencode($reference)); if(!$response->successful()) throw new \RuntimeException('Unable to verify payment.'); return ['success'=>(bool)$response->json('status'),'reference'=>$reference,'status'=>$response->json('data.status'),'data'=>$response->json('data',[])]; }
}
