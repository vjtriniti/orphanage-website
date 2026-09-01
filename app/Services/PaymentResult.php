<?php
namespace App\Services;
class PaymentResult { public function __construct(public bool $success, public ?string $reference=null, public ?string $redirectUrl=null, public array $data=[]) {} }
