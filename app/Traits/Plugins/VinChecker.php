<?php

namespace App\Traits\Plugins;

use Illuminate\Support\Facades\Http;

class VinChecker
{
	public static function sendVin($vin)
	{
		$id = 'azfixit45com';
		$key = 'k2c7jap3bq8cv2xjqz5c9s1zl5vm';

		$response = Http::withOptions([
            'verify' => false,
        ])->get('https://vindecodervehicle.com/api/v1/?/', [
		    'id' => $id,
		    'key' => $key,
		    'vin' => $vin,
		]);
		
		$res = json_decode($response->body(), true );

		if($res == null){
			return [];
		}

		$vinResponse = $res['Results'][0];

        return [
            'vin_number' => $vin,
            'make' => $vinResponse['Make'],
            'manufacturer' => $vinResponse['Manufacturer'],
            'model' => $vinResponse['Model'],
            'model_year' => $vinResponse['ModelYear'],
            'plant_company_name' => $vinResponse['PlantCompanyName'],
            'plant_country' => $vinResponse['PlantCountry'],
            'plant_state' => $vinResponse['PlantState'],
            'series' => $vinResponse['Series'],
            'series_description' => $vinResponse['Series2'],
            'vehicle_type' => $vinResponse['VehicleType'],
            'trim' => $vinResponse['Trim'],
            'body_class' => $vinResponse['BodyClass'],
            'engine_configuration' => $vinResponse['EngineConfiguration'],
            'engine_cylinders' => $vinResponse['EngineCylinders'],
            'engine_hp' => $vinResponse['EngineHP'],
            'engine_kw' => $vinResponse['EngineKW'],
            'engine_model' => $vinResponse['EngineModel'],
            'fuel_type' => $vinResponse['FuelTypePrimary'],
            'doors' => $vinResponse['Doors'],
            'driver_type' => $vinResponse['DriveType'],
        ];
	}
}