<?php

namespace App\Traits\Payment;

use Illuminate\Support\Facades\Http;

class Wallet
{
    public function verify($reference, $type = "order")
    {
        // $tx = json_decode($response->body());
        if ($tx['status'] && $tx['data']['status'] == "success") {
            $txData = $tx['data'];
            switch ($type) {
                case 'order':
                    $data = [
                        'amount_paid' => $txData['amount'] / 100,
                        // 'currency_id' => '',
                        'currency' => $txData['currency'],
                        'payment_method' => $txData['channel'],
                        'payment_gateway' => "paystack",
                        // 'payment_gateway_charged_percentage' => '',
                        // 'payment_gateway_expected_charged_percentage' => '',
                        'payment_reference' => $reference,
                        'payment_gateway_charge' => $txData['fees'],
                        // 'payment_gateway_remittance' => '',
                        // 'payment_code' => '',
                        'payment_message' => $tx['message'],
                        'payment_status' => $txData['status'],
                        // 'platform_initiated' => '',
                        'transaction_initiated_date' => $txData['transaction_date'],
                        'transaction_initiated_time' => $txData['transaction_date'],
                        'date_time_paid' => now(),
                        'status' => 'approved',
                        'service_status' => 'approved',
                    ];
                    break;
                default:
                    $data = [];
                    break;
            }
            return ["success", $data];
        } else {
            return ["error", $tx['message']];
        }
    }
}
