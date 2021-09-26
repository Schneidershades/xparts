<?php

namespace App\Traits\Payment;

use Illuminate\Support\Facades\Http;

class Paystack
{
    protected $baseUrl;
    protected $env;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->baseUrl = env('PAYSTACK_PAYMENT_URL');
        $this->env = env('PAYSTACK_ENV');
        if ($this->env == "test") {
            $this->secretKey = env('PAYSTACK_TEST_SECRET_KEY');
            $this->publicKey = env('PAYSTACK_TEST_PUBLIC_KEY');
        } else {
            $this->secretKey = env('PAYSTACK_LIVE_SECRET_KEY');
            $this->publicKey = env('PAYSTACK_LIVE_PUBLIC_KEY');
        }
    }

    public function verify($reference)
    {
        $response = Http::withToken($this->secretKey)
            ->asJson()
            ->get($this->baseUrl . "/transaction/verify/$reference");

        return json_decode($response->body());
    }
}
