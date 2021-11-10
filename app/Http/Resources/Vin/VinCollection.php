<?php

namespace App\Http\Resources\Vin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VinCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => VinResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'vin_number' => 'vin_number',
            'make' => 'make',
            'model' => 'model',
            'year' => 'year',
            'manufacturer' => 'manufacturer',
            'plant_company_name' => 'plant_company_name',
            'plant_country' => 'plant_country',
            'plant_state' => 'plant_state',
            'series' => 'series',
            'series_description' => 'series_description',
            'trim' => 'trim',
            'body_class' => 'body_class',
            'engine_configuration' => 'engine_configuration',
            'engine_cylinders' => 'engine_cylinders',
            'engine_hp' => 'engine_hp',
            'engine_kw' => 'engine_kw',
            'engine_model' => 'engine_model',
            'fuel_type' => 'fuel_type',
            'doors' => 'doors',
            'driver_type' => 'driver_type',
            'search_count' => 'search_count',
            'admin_attention' => 'admin_attention',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'vin_number' => 'vin_number',
            'make' => 'make',
            'model' => 'model',
            'year' => 'year',
            'manufacturer' => 'manufacturer',
            'plant_company_name' => 'plant_company_name',
            'plant_country' => 'plant_country',
            'plant_state' => 'plant_state',
            'series' => 'series',
            'series_description' => 'series_description',
            'trim' => 'trim',
            'body_class' => 'body_class',
            'engine_configuration' => 'engine_configuration',
            'engine_cylinders' => 'engine_cylinders',
            'engine_hp' => 'engine_hp',
            'engine_kw' => 'engine_kw',
            'engine_model' => 'engine_model',
            'fuel_type' => 'fuel_type',
            'doors' => 'doors',
            'driver_type' => 'driver_type',
            'search_count' => 'search_count',
            'admin_attention' => 'admin_attention',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
    
}
