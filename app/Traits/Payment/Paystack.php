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
        // $data_string = json_encode($query);
                
        $ch = curl_init($this->baseUrl . "/transaction/verify/$reference");                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "Authorization: Bearer ".$this->secretKey,
            "Cache-Control: no-cache",
          ));                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        $tx = json_decode($response, true);
        
        // $response = Http::withToken($this->secretKey)
        //     ->asJson()
        //     ->get($this->baseUrl . "/transaction/verify/$reference");

        // $tx = json_decode($response->body());

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
