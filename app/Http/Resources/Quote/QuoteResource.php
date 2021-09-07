<?php

namespace App\Http\Resources\Quote;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
            'xpart_request_id' => $this->xpart_request_id,
            'vendor_id' => $this->vendor_id,
            'part_grade_id' => $this->part_grade_id,
            'part_category_id' => $this->part_category_id,
            'part_subcategory_id' => $this->part_subcategory_id,
            'part_condition_id' => $this->part_condition_id,
            'brand' => $this->brand,
            'quantity' => $this->quantity,
            'part_number' => $this->part_number,
            'part_warranty' => $this->part_warranty,
            'price' => $this->price,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}