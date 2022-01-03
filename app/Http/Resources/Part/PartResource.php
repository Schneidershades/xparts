<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'number_of_delivered_quotes' => $this->number_of_delivered_quotes
        ];
    }
}