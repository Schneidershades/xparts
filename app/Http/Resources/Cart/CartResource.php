<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            $this->mergeWhen($this->cartable_type == 'quotes', [
                'title' => $this->cartable->xpartRequest->part->name,

                'business' => $this->cartable->xpartRequest->vendor->addresses,

                'description' => $this->cartable->partGrade->name.' '.$this->cartable->brand .' '.$this->cartable->part_number,
            ]),

            'category' => $this->cartable_type,
            'price' => $this->cartable->price,
            'quantity' => $this->quantity,
            'total' => $this->cartable->price * $this->quantity,
        ];
    }
}
