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

		$vinResponse = $res['Results'] ? $res['Results'][0] : null;

        if($vinResponse != null){
            return [
                'vin_number' => $vin,
                'make' => $vinResponse['Make'] != "" ? $vinResponse['Make'] : null  ,
                'manufacturer' => $vinResponse['Manufacturer'] ? $vinResponse['Manufacturer'] : null,
                'model' => $vinResponse['Model'] ? $vinResponse['Model'] : null,
                'model_year' => $vinResponse['ModelYear'] ? $vinResponse['ModelYear'] : null,
                'plant_company_name' => $vinResponse['PlantCompanyName'] ? $vinResponse['PlantCompanyName'] : null,
                'plant_country' => $vinResponse['PlantCountry'] ? $vinResponse['PlantCountry'] : null,
                'plant_state' => $vinResponse['PlantState'] ? $vinResponse['PlantState'] : null,
                'series' => $vinResponse['Series'] ? $vinResponse['Series'] : null,
                'series_description' => $vinResponse['Series2'] ? $vinResponse['Series2'] : null,
                'vehicle_type' => $vinResponse['VehicleType'] ? $vinResponse['VehicleType'] : null,
                'trim' => $vinResponse['Trim'] ? $vinResponse['Trim'] : null,
                'body_class' => $vinResponse['BodyClass'] ? $vinResponse['BodyClass'] : null,
                'engine_configuration' => $vinResponse['EngineConfiguration'] ? $vinResponse['EngineConfiguration'] : null,
                'engine_cylinders' => $vinResponse['EngineCylinders'] ? $vinResponse['EngineCylinders'] : null,
                'engine_hp' => $vinResponse['EngineHP'] ? $vinResponse['EngineHP'] : null,
                'engine_kw' => $vinResponse['EngineKW'] ? $vinResponse['EngineKW'] : null,
                'engine_model' => $vinResponse['EngineModel'] ? $vinResponse['EngineModel'] : null,
                'fuel_type' => $vinResponse['FuelTypePrimary'] ? $vinResponse['FuelTypePrimary'] : null,
                'doors' => $vinResponse['Doors'] ? $vinResponse['Doors'] : null,
                'driver_type' => $vinResponse['DriveType'] ? $vinResponse['DriveType'] : null,
            ];
        }else{
            return $vinResponse;
        }
	}
}