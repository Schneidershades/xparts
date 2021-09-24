<?php

namespace App\Http\Resources\Vin;

use Illuminate\Http\Resources\Json\JsonResource;

class VinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vin_number' => $this->vin_number,
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->model_year,
            'manufacturer' => $this->manufacturer,
            'plant_company_name' => $this->plant_company_name,
            'plant_country' => $this->plant_country,
            'plant_state' => $this->plant_state,
            'series' => $this->series,
            'series_description' => $this->series_description,
            'vehicle_type' => $this->vehicle_type,
            'trim' => $this->trim,
            'body_class' => $this->body_class,
            'engine_configuration' => $this->engine_configuration,
            'engine_cylinders' => $this->engine_cylinders,
            'engine_hp' => $this->engine_hp,
            'engine_kw' => $this->engine_kw,
            'engine_model' => $this->engine_model,
            'fuel_type' => $this->fuel_type,
            'doors' => $this->doors,
            'driver_type' => $this->driver_type,
            'search_count' => $this->search_count,
        ];
    }
}