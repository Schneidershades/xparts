<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PartGradeCollection extends ResourceCollection
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
            'data' => PartGradeResource::collection($this->collection),
        ];
    }
}
