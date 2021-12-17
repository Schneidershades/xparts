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
                
                // 'brand' => $this->itemable ? $this->itemable->brand : 'N/A',
                // 'part_number' => $this->itemable ? $this->itemable->part_number : 'N/A',
                // 'vendor_id' => $this->itemable ? $this->itemable->vendor_id : 'N/A',
                // 'measurement' => $this->itemable ? $this->itemable->measurement : null,
                // 'available_stock' => $this->itemable ? $this->itemable->quantity : null,
                // 'make' => $this->itemable ? $this->itemable->xpartRequest->vin->make : null,
                // 'model' => $this->itemable ?  $this->itemable->xpartRequest->vin->model : null,
                // 'year' => $this->itemable ?  $this->itemable->xpartRequest->vin->model_year : null, 
                // 'status' => $this->itemable ? $this->itemable->status : 'N/A',
                // 'price' => $this->itemable ? $this->itemable->markup_price : 'N/A',
                // 'total' => $this->itemable ? $this->itemable->markup_price : 0 * $this->quantity,
            // ]),

            'receipt_number' => $this->receipt_number ? $this->receipt_number : null,
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'quantity' => $this->quantity,
        ];
    }
    
}
