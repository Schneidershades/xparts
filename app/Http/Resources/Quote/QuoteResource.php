<?php

namespace App\Http\Resources\Quote;

use App\Http\Resources\User\VendorResource;
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
            'xpartRequestPart' => $this->xpartRequest->part->name,
            'xpartRequestVin' => $this->xpartRequest->vin->vin_number,
            'vendor' => new VendorResource($this->vendor),
            'grade' => $this->partGrade->name,
            'brand' => $this->brand,
            'quantity' => $this->quantity,
            'part_number' => $this->part_number,
            'part_warranty' => $this->part_warranty,
            'measurement' => $this->measurement,
            'actual_price' => $this->price,
            
            $this->mergeWhen(auth()->user()->role != 'admin' && auth()->user()->role != 'user', [
                'price' => $this->price,
            ]),

            $this->mergeWhen(auth()->user()->role == 'vendor', [
                'price' => $this->price,
            ]),

            $this->mergeWhen(auth()->user()->role == 'user', [
                'price' => $this->markup_price ? $this->markup_price :  $this->price,
            ]),
            
            'description' => $this->description,
            'status' => $this->status,
            'state' => $this->state ? $this->state->name : 'N/A',
            'city' => $this->city ? $this->city->name : 'N/A',
            'country' => $this->country ? $this->country->name : 'N/A',
            'images' => $this->images != null ? $this->images->pluck('file_url') : null,
            'markup_price' => $this->markup_price,
            'markup_price_details' => $this->markupPricing,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}