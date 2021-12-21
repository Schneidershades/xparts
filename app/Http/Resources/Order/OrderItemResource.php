<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            // $this->mergeWhen($this->itemable == 'quotes', [
                'title' => $this->itemable?->xpartRequest?->part?->name,
                'grade' => $this->itemable?->partGrade?->name,
                'brand' => $this->itemable?->brand,
                'part_number' => $this->itemable?->part_number,
                'vendor_id' => $this->itemable?->vendor_id,
                'measurement' => $this->itemable?->measurement,
                'available_stock' => $this->itemable?->quantity,
                'make' => $this->itemable?->xpartRequest?->vin?->make,
                'model' => $this->itemable?->xpartRequest?->vin?->model,
                'year' => $this->itemable?->xpartRequest?->vin?->model_year,
                'status' => $this->itemable?->status,
                'price' => $this->itemable?->markup_price,
                'total' => $this->itemable ? $this->itemable?->markup_price : 0 * $this->quantity,
            // ]),

            'receipt_number' => $this->receipt_number ? $this->receipt_number : null,
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'quantity' => $this->quantity,
        ];
    }
    
}
