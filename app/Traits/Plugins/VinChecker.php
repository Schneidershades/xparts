<?php

namespace App\Traits\Plugins;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VinChecker
{
	public static function sendOtp($vin)
	{
		$rand = rand(1000, 9999);

		$response = Http::withOptions([
            'verify' => false,
        ])->get('https://vindecodervehicle.com/api/', [
		    'id' => 'YOURUSER',
		    'key' => 'XXXXXXXXXXXXXXX',
		    'vin' => $vin,
		]);

		$otp = json_decode($response->body(), true);

        return [
        ];
	}
}