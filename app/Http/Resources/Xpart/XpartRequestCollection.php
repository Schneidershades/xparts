<?php

namespace App\Http\Resources\Xpart;

use Illuminate\Http\Resources\Json\ResourceCollection;

class XpartRequestCollection extends ResourceCollection
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
            'data' => XpartRequestResource::collection($this->collection),
        ];
    }
}
