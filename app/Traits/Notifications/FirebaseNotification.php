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
        // $token = "";  
        
        $data = [
            "registration_ids" => $user->fcmPushSubscriptions->pluck('fcm_token')->toArray(),
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