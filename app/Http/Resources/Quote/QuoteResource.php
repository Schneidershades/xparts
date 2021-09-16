<?php

namespace App\Http\Resources\Quote;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Xpart\XpartRequestResource;

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
            'xpartRequest' => new XpartRequestResource($this->xpartRequest),
            'vendor' => new UserResource($this->vendor),
            'grade' => $this->partGrade->name,
            'category' => $this->partCategory->name,
            'subCategory' => $this->partSubcategory->name,
            'partCondition' => $this->partCondition->name,
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