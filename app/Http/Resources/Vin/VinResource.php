<?php

namespace App\Http\Resources\Vin;

use Illuminate\Http\Resources\Json\JsonResource;

class VinResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vin_number' => $this->vin_number,
            'make' => $this->make ? $this->make : 'N/A',
            'model' => $this->model ? $this->model : 'N/A',
            'year' => $this->model_year ? $this->model_year : 'N/A',
            'manufacturer' => $this->manufacturer ? $this->manufacturer : 'N/A',
            'plant_company_name' => $this->plant_company_name ? $this->plant_company_name : 'N/A',
            'plant_country' => $this->plant_country ? $this->plant_country : 'N/A',
            'plant_state' => $this->plant_state ? $this->plant_state : 'N/A',
            'series' => $this->series ? $this->series : 'N/A',
            'series_description' => $this->series_description ? $this->series_description : 'N/A',
            'vehicle_type' => $this->vehicle_type ? $this->vehicle_type : 'N/A',
            'trim' => $this->trim ? $this->trim : 'N/A',
            'body_class' => $this->body_class ? $this->body_class : 'N/A',
            'engine_configuration' => $this->engine_configuration ? $this->engine_configuration : 'N/A',
            'engine_cylinders' => $this->engine_cylinders ? $this->engine_cylinders : 'N/A',
            'engine_hp' => $this->engine_hp ? $this->engine_hp : 'N/A',
            'engine_kw' => $this->engine_kw ? $this->engine_kw : 'N/A',
            'engine_model' => $this->engine_model ? $this->engine_model : 'N/A',
            'fuel_type' => $this->fuel_type ? $this->fuel_type : 'N/A',
            'doors' => $this->doors ? $this->doors : 'N/A',
            'driver_type' => $this->driver_type ? $this->driver_type : 'N/A',
            'search_count' => $this->search_count ? $this->search_count : 'N/A',
            'admin_attention' => $this->admin_attention,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}