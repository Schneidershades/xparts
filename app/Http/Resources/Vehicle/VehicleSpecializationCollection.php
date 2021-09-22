<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleSpecializationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => VehicleSpecializationResource::collection($this->collection),
        ];
    }
}
