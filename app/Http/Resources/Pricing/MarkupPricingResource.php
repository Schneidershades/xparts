<?php

namespace App\Http\Resources\Pricing;

use Illuminate\Http\Resources\Json\JsonResource;

class MarkupPricingResource extends JsonResource
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
            'min_value' => $this->min_value,
            'max_value' => $this->max_value,
            'percentage' => $this->percentage,
            'type' => $this->type,
            'active' => $this->active ? true : false,
        ];
    }
}
