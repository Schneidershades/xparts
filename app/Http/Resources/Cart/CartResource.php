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
                'grade' => $this->cartable->partGrade->name,
                'brand' => $this->cartable->brand,
                'part_number' => $this->cartable->part_number,
                'mesaurement' => $this->cartable->mesaurement,
                'vendor_id' => $this->cartable->vendor_id,
            ]),
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'price' => $this->cartable->price,
            'quantity' => $this->quantity,
            'total' => $this->cartable->price * $this->quantity,
        ];
    }
}
