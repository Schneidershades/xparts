<?php

namespace App\Http\Resources\Vin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VinCollection extends ResourceCollection
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
            'data' => VinResource::collection($this->collection),
        ];
    }
    
}
