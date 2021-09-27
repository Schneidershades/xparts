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

    public function verify($reference, $type = "order")
    {
        $response = Http::withToken($this->secretKey)
            ->asJson()
            ->get($this->baseUrl . "/transaction/verify/$reference");

        $tx = json_decode($response->body());
        if ($tx->status && $tx->data->status == "success") {
            $txData = $tx->data;
            switch ($type) {
                case 'order':
                    $data = [
                        'amount_paid' => $txData->amount / 100,
                        // 'currency_id' => '',
                        'currency' => $txData->currency,
                        'payment_method' => $txData->channel,
                        'payment_gateway' => "paystack",
                        // 'payment_gateway_charged_percentage' => '',
                        // 'payment_gateway_expected_charged_percentage' => '',
                        'payment_reference' => $reference,
                        'payment_gateway_charge' => $txData->fees,
                        // 'payment_gateway_remittance' => '',
                        // 'payment_code' => '',
                        'payment_message' => $tx->message,
                        'payment_status' => $txData->status,
                        // 'platform_initiated' => '',
                        'transaction_initiated_date' => $txData->transaction_date,
                        'transaction_initiated_time' => $txData->transaction_date,
                        'date_time_paid' => now(),
                    ];
                    break;
                default:
                    $data = [];
                    break;
            }
            return ["success", $data];
        } else {
            return ["error", $tx->message];
        }
    }
}
