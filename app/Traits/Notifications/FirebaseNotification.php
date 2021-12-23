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
        // $from = "AIzaSyBwH2ZJh_-ezlR0aw_Y29wS9TQzMYHMF-I";
        // $from = "262314706287";
        // $msg = array(
        //     // 'user'  => $user,
        //     'body'  => $body,
        //     'title' => $title,
        //     // 'key' => $notificationKey,
        //     // 'property' => $notification,
        //     // 'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png", /*Default Icon*/
        //     // 'sound' => 'mySound',/*Default sound*/
        //     // 'id' => $notification->id,
        //     // 'type_class' => get_class($notification),
        // );

        // $fields = array(
        //     'registration_ids'  => $user->fcmPushSubscriptions->pluck('fcm_token')->toArray(),
        //     // 'to'                => $user->fcm_token,
        //     'notification'      => $msg
        // );

        // $headers = array(
        //     'Authorization: key=' . $token,
        //     'Content-Type: application/json',
        //     'Accept: application/json',
        // );

        // $ch = curl_init();
        // curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        // curl_setopt( $ch,CURLOPT_POST, true );
        // curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        // curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        // curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        // $result = curl_exec($ch );
        // ($result);
        // curl_close( $ch );

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

        // $data = array(
        //     'user'  => $user,
        //     'key' => $notificationKey,
        //     'property' => $notification,
        // );

        // $optionBuilder = new OptionsBuilder();
        // $optionBuilder->setTimeToLive(60*20);

        // $notificationBuilder = new PayloadNotificationBuilder($title);
        // $notificationBuilder->setBody($body)
        //                     ->setSound('default');

        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData([ 'data' => $data ]);

        // $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        // $tokens = $user->fcmPushSubscriptions->pluck('fcm_token')->toArray();

        // $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        // dd($downstreamResponse);

        // $downstreamResponse->numberSuccess();
        // $downstreamResponse->numberFailure();
        // $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        // $downstreamResponse->tokensToDelete();

        // return Array (key : oldToken, value : new token - you must change the token in your database)
        // $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        // $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        // $downstreamResponse->tokensWithError();
    }
}