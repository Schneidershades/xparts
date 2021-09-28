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
        $this->baseUrl = config('paystack.url');
        $this->secretKey = config('paystack.secret_key');
        $this->publicKey = config('paystack.public_key');
    }

    public function verify($reference, $type = "order")
    {
        // $response = Http::withToken($this->secretKey)
        //     ->asJson()
        //     ->get($this->baseUrl . "/transaction/verify/$reference");

        return $this->secretKey.' ce';

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$this->secretKey,
            "Cache-Control: no-cache",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return ($response);

        return $tx = json_decode($response, true);

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
