<?php

namespace App\Traits\Plugins;

class VinCarMd
{
	public static function sendVin($vin)
	{
        $res = $this->sendRequest("http://api.carmd.com/v3.0/decode?vin=".$vin, 'GET', []);

		if($res == null){
			return [];
		}

		$vinResponse = $res['Results'] ? $res['Results'][0] : null;

        if($vinResponse['ModelYear'] != '' || $vinResponse['Model'] != '' || $vinResponse['Make'] != ''){
            return [
                'vin_number' => $vin,
                'make' => $vinResponse['Make'] != "" ? $vinResponse['Make'] : null  ,
                'manufacturer' => $vinResponse['Manufacturer'] != "" ? $vinResponse['Manufacturer'] : null,
                'model' => $vinResponse['Model'] != "" ? $vinResponse['Model'] : null,
                'model_year' => $vinResponse['ModelYear'] != "" ? $vinResponse['ModelYear'] : null,
                'plant_company_name' => $vinResponse['PlantCompanyName'] != "" ? $vinResponse['PlantCompanyName'] : null,
                'plant_country' => $vinResponse['PlantCountry']!= "" ? $vinResponse['PlantCountry'] : null,
                'plant_state' => $vinResponse['PlantState'] != "" ? $vinResponse['PlantState'] : null,
                'series' => $vinResponse['Series'] != "" ? $vinResponse['Series'] : null,
                'series_description' => $vinResponse['Series2'] != "" ? $vinResponse['Series2'] : null,
                'vehicle_type' => $vinResponse['VehicleType'] != "" ? $vinResponse['VehicleType'] : null,
                'trim' => $vinResponse['Trim'] != "" ? $vinResponse['Trim'] : null,
                'body_class' => $vinResponse['BodyClass'] != "" ? $vinResponse['BodyClass'] : null,
                'engine_configuration' => $vinResponse['EngineConfiguration'] != "" ? $vinResponse['EngineConfiguration'] : null,
                'engine_cylinders' => $vinResponse['EngineCylinders'] != "" ? $vinResponse['EngineCylinders'] : null,
                'engine_hp' => $vinResponse['EngineHP'] != "" ? $vinResponse['EngineHP'] : null,
                'engine_kw' => $vinResponse['EngineKW'] != "" ? $vinResponse['EngineKW'] : null,
                'engine_model' => $vinResponse['EngineModel'] != "" ? $vinResponse['EngineModel'] : null,
                'fuel_type' => $vinResponse['FuelTypePrimary'] != "" ? $vinResponse['FuelTypePrimary'] : null,
                'doors' => $vinResponse['Doors'] != "" ? $vinResponse['Doors'] : null,
                'driver_type' => $vinResponse['DriveType'] != "" ? $vinResponse['DriveType'] : null,
            ];
        }else{
            return [];
        }
	}


    public function sendRequest($url, $requestType, $postfields=[])
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
                "content-type: application/json",
                "authorization: Basic ZjhiY2U2NGQtMzUxOS00YzZiLTljYmEtOGQ2MDI3NzRjOGQw",
                "partner-token: 24df3d305c0c4db396af0bd70519de89"
            ],
        ]);

        $response = curl_exec($curl);
        return json_decode($response);
    }
}
