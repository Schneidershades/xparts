<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Resources\Json\JsonResource;

class PartSubcategoryResource extends JsonResource
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
            'name' => $this->name,
            'part_category_id' => $this->part_category_id,
        ];
    }
}
