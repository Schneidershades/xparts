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
            "Authorization: Bearer ".config('paystack.secret_key'),
            "Cache-Control: no-cache",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $tx = json_decode($response, true);

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

    public function createTransferReceipient($bankDetails)
    {
        $request_body = [
            "type" => "xparts user ".$bankDetails->user->id . " - ".$bankDetails->user->name,
            "name" => $bankDetails->user->name,
            "description" => "Xparts user withdrawal process ".$bankDetails->user->id . " - ".$bankDetails->user->name,
            "account_number" => $bankDetails->bank_account_number,
            "bank_code" => $bankDetails->bank->code,
            "currency" => "NGN"
        ];

        $response = $this->sendRequest("https://api.paystack.co/transferrecipient", 'POST', json_encode($request_body));

        if($response == null){
            return [
                'status' => false,
                'message' => 'cannot connect to service'
            ];
        }

        if($response->status == false ){
            return [
                'status' => $response->status,
                'message' => $response->message
            ];
        }

        if($response->status == true ){
            return [
                'status' => $response->status,
                'paystack_recipient_code' => $response->data->recipient_code,
            ];
        }
    }

    public function initiateTransfer($bankDetails, $amount, $code)
    {
        $request_body = [
            "source" => "balance", 
            "reason" => "Withdrawals from xparts aplication user". $bankDetails->user->id.  " - " .$bankDetails->user->name, 
            "amount" => $amount * 100, 
            "recipient" => $code,
        ];

        $response = $this->sendRequest("https://api.paystack.co/transfer", 'POST', json_encode($request_body));
        
        if($response == null){
            return [
                'status' => false,
                'message' => 'cannot connect to service'
            ];
        }

        if($response->status == false ){
            return [
                'status' => $response->status,
                'message' => $response->message
            ];
        }

        if($response->status == true ){
            return [
                'status' => $response->status,
                'message' => $response->message,
                'transfer_code' => $response->data->transfer_code,
                'payment_transfer_code' => $response->data->transfer_code,
                'payment_recipient_code' => $code,
                'payment_transfer_status' => $response->data->status,
            ];
        }
    }

    public function finalizeTransfer($order, $otp)
    {
        $request_body = [
            "transfer_code" => $order->payment_transfer_code, 
            "otp" => $otp
        ];
       
        $response = $this->sendRequest("https://api.paystack.co/transfer/finalize_transfer", 'POST', json_encode($request_body));

        if($response == null){
            return [
                'status' => false,
                'message' => 'cannot connect to service'
            ];
        }

        if($response->status == false ){
            return [
                'status' => $response->status,
                'message' => $response->message
            ];
        }

        if($response->status == true ){
            return [
                'status' => $response->status,
                'message' => $response->message,
                'transfer_code' => $response->data->transfer_code,
                'payment_reference' => $response->data->reference,
                'stage' => $response->data->status,
            ];
        }
    }

    public function verifyTransfer($reference)
    {
        $response = $this->sendRequest("https://api.paystack.co/transfer/verify/". $reference, 'GET', []);

        if($response == null){
            return [
                'status' => false,
                'message' => 'cannot connect to service'
            ];
        }

        if($response->status == false ){
            return [
                'status' => $response->status,
                'message' => $response->message
            ];
        }

        if($response->status == true ){
            return [
                'status' => $response->status,
                'message' => $response->message,
                'payment_reference' => $response->data->reference,
                'payment_recipient_code' => $response->data->transfer_code,
                'payment_transfer_stage' => $response->data->status,
            ];
        }
    }

    private function sendRequest($url, $requestType, $postfields=[])
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: Bearer ".config('paystack.secret_key'),
            ],
        ]);

        $response = curl_exec($curl);
        return json_decode($response);
    }
}
