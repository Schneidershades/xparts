<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address' => $this->address,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'state' => $this->state ? $this->state->name : 'N/A',
            'city' => $this->city ? $this->city->name : 'N/A',
            'country' => $this->country ? $this->country->name : 'N/A',
            'postal_code' => $this->postal_code,
            'default' => $this->primary_address ? true : false,
            'rate' => $this->city->relations,

            // $this->mergeWhen($this->state->stateDeliveryRate != null && $this->city->cityDeliveryRate != null, [
            //     'delivery_rate' => $this->city->cityDeliveryRate?->amount,
            // ]),

            // $this->mergeWhen($this->state->stateDeliveryRate != null || $this->city->cityDeliveryRate == null, [
            //     'delivery_rate' => $this->state->stateDeliveryRate?->amount,
            // ]),

            // $this->mergeWhen($this->state->stateDeliveryRate == null || $this->city->cityDeliveryRate != null, [
            //     'delivery_rate' => $this->city->cityDeliveryRate?->amount,
            // ]),

            // $this->mergeWhen($this->state->stateDeliveryRate == null && $this->city->cityDeliveryRate == null, [
            //     'delivery_rate' => $this->city->flatRate()?->amount,
            // ]),

        ];
    }
}