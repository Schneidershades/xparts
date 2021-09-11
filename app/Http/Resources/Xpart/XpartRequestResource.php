<?php

namespace App\Http\Resources\Xpart;

use App\Http\Resources\Vin\VinResource;
use App\Http\Resources\Part\PartResource;
use Illuminate\Http\Resources\Json\JsonResource;

class XpartRequestResource extends JsonResource
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
            'part' => new PartResource($this->part),
            'vin' => new VinResource($this->vin),
        ];
    }
}
