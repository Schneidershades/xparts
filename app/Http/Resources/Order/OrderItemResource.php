<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            $this->mergeWhen($this->itemable_type == 'quotes' && $this->itemable_type != null && $this->itemable_id != null, [

                'title' => $this->itemable_type ? optional($this->itemable->xpartRequest)->part->name : 'N/A',
                'grade' => $this->itemable_type ?  optional($this->itemable->xpartRequest)->partGrade->name : 'N/A',
                'brand' => $this->itemable_type ? optional($this->itemable->xpartRequest)->brand : 'N/A',
                'part_number' => $this->itemable_type ? optional($this->itemable->xpartRequest)->part_number : 'N/A',
                'vendor_id' => $this->itemable_type ? optional($this->itemable->xpartRequest)->vendor_id : 'N/A',

                'measurement' => $this->itemable_type ? optional($this->itemable->xpartRequest)->measurement : null,
                'available_stock' => $this->itemable_type ? optional($this->itemable->xpartRequest)->quantity : null,
                'make' => $this->itemable_type ? optional($this->itemable->xpartRequest)->xpartRequest->vin->make : null,
                'model' => $this->itemable_type ?  optional($this->itemable->xpartRequest)->xpartRequest->vin->model : null,
                'year' => $this->itemable_type ?  optional($this->itemable->xpartRequest)->xpartRequest->vin->model_year : null,
                
                'status' => $this->itemable_type ? optional($this->itemable->xpartRequest)->status : 'N/A',
                'price' => $this->itemable_type ? optional($this->itemable->xpartRequest)->markup_price : 'N/A',
                'total' => $this->itemable_type ? optional($this->itemable->xpartRequest)->markup_price : 0 * $this->quantity,
            ]),

            'receipt_number' => $this->receipt_number ? $this->receipt_number : null,
            
            'cartable_type' => $this->cartable_type,
            'cartable_id' => $this->cartable_id,

            'category' => $this->cartable_type,
            'quantity' => $this->quantity,
        ];
    }
    
}
