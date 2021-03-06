<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PartSpecializationCollection extends ResourceCollection
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
            'data' => PartSpecializationResource::collection($this->collection),
        ];
    }
}
