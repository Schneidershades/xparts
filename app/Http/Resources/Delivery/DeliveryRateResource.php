<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryRateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'destinatable_id' => $this->destinatable_id,
            'destinatable_type' => $this->destinatable_type,
            'amount' => $this->amount,
        ];
    }
}
