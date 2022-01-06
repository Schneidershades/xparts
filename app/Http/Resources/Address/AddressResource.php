<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
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
            // 'delivery_rate' => $this->city->flatRate()?->amount,

            // if address has any delivery rate on city leave country & state

            // if address has any delivery rate no city has state leave country

            // if address has any delivery rate no city has state leave country


            $this->mergeWhen($this->state->rate != null && $this->city->rate != null, [
                'delivery_rate' => $this->city->rate?->amount,
            ]),

            // $this->mergeWhen($this->state->rate != null || $this->city->rate == null, [
            //     'delivery_rate' => $this->state->rate?->amount,
            // ]),

            // $this->mergeWhen($this->state->rate == null || $this->city->rate != null, [
            //     'delivery_rate' => $this->city->rate?->amount,
            // ]),

            // $this->mergeWhen($this->state->rate == null && $this->city->rate == null && $this->country->rate == null , [
            //     'delivery_rate' => $this->city->flatRate()?->amount,
            // ]),

        ];
    }
}