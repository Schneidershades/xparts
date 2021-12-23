<?php

namespace App\Traits\Notifications;

use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FirebaseNotification
{
    public function sendPushNotification($notification, $notificationKey, $user, $title, $body)
    {
        $token = "AAAAPRMsxW8:APA91bEy2IxbBmgsXdPIw_tnf95bOtN8XI4rMU_SOUjbP1EGo2pCNvJ3LE5Yo8rgR5-7kUvnnf7lA3rxSNjvq56PPYuySZA7-oulbynmx7lERVbDOpvZOWcffW-J0P_blNcuEWNAT345";  
        
        $data = [
            "to"=> "f_2yYzCTRYSUAurIMEDe_m:APA91bG9kJwPwhNkcnytFymEvUbpML3IaquQW64sMfz3-qpLyVyWu1QPe5km6Z0n348o8sMYe268YVr3cPs9h0YEzz_-rnF9atM9_ldByw9GT5vqw3Dy11FsPdCw9XSs_T9_izsIMsQ1",
            // "registration_ids" => $user->fcmPushSubscriptions->pluck('fcm_token')->toArray(),
            "notification" => [
                "title" => $title,
                "body" => $body,  
            ]
        ];

        $dataString = json_encode($data);
      
        $headers = [
            'Authorization: key=' . $token,
            'Content-Type: application/json',
            'Accept: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);

        Log::debug('push notification sent successfully');
    }
}