<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            $this->mergeWhen($this->itemable_type == 'quotes', [
                'title' => $this->itemable->xpartRequest ? $this->itemable->xpartRequest->part->name : null,
                'grade' => $this->itemable->partGrade ??  $this->itemable->partGrade->name,
                'brand' => $this->itemable ?? $this->itemable->brand,
                'part_number' => $this->itemable ?? $this->itemable->part_number,
                'vendor_id' => $this->itemable ?? $this->itemable->vendor_id,
            ]),
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'price' => $this->itemable->price,
            'quantity' => $this->quantity,
            'total' => $this->itemable->price * $this->quantity,
        ];
    }
}
