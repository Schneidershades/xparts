<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'id' => $this->itemable_type,

            // $this->mergeWhen($this->itemable_type == 'quotes' && $this->itemable_type != null && $this->itemable_id != null, [

                // 'title' => $this->itemable_type ? $this->itemable->xpartRequest->part->name : 'N/A',
                // 'grade' => $this->itemable_type ?  $this->itemable->partGrade->name : 'N/A',
                // 'brand' => $this->itemable_type ? $this->itemable->brand : 'N/A',
                // 'part_number' => $this->itemable_type ? $this->itemable->part_number : 'N/A',
                // 'vendor_id' => $this->itemable_type ? $this->itemable->vendor_id : 'N/A',

                // 'measurement' => $this->itemable_type ? $this->itemable->measurement : null,
                // 'available_stock' => $this->itemable_type ? $this->itemable->quantity : null,
                // 'make' => $this->itemable_type ? $this->itemable->xpartRequest->vin->make : null,
                // 'model' => $this->itemable_type ?  $this->itemable->xpartRequest->vin->model : null,
                // 'year' => $this->itemable_type ?  $this->itemable->xpartRequest->vin->model_year : null,
                
                // 'status' => $this->itemable_type ? $this->itemable->status : 'N/A',
                // 'price' => $this->itemable_type ? $this->itemable->markup_price : 'N/A',
                // 'total' => $this->itemable_type ? $this->itemable->markup_price : 0 * $this->quantity,
                
            // ]),

            'receipt_number' => $this->receipt_number ? $this->receipt_number : null,
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'quantity' => $this->quantity,
        ];
    }
    
}
