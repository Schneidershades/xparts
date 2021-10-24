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
                'title' => $this->itemable ? $this->itemable->xpartRequest->part->name : 'N/A',
                'grade' => $this->itemable ?  $this->itemable->partGrade->name : 'N/A',
                'brand' => $this->itemable ? $this->itemable->brand : 'N/A',
                'part_number' => $this->itemable ? $this->itemable->part_number : 'N/A',
                'vendor_id' => $this->itemable ? $this->itemable->vendor_id : 'N/A',

                'measurement' => $this->itemable->measurement ? $this->itemable->measurement : null,
                'available_stock' => $this->itemable->quantity ? $this->itemable->quantity : null,
                'make' => $this->itemable->xpartRequest ? $this->itemable->xpartRequest->vin->make : null,
                'model' => $this->itemable->xpartRequest ?  $this->itemable->xpartRequest->vin->model : null,
                'year' => $this->itemable->xpartRequest ?  $this->itemable->xpartRequest->vin->model_year : null,
            ]),
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'price' => $this->itemable ? $this->itemable->price : 'N/A',
            'quantity' => $this->quantity,
            'total' => $this->itemable ? $this->itemable->price : 0 * $this->quantity,
        ];
    }
}
