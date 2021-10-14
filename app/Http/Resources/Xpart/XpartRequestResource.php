<?php

namespace App\Http\Resources\Xpart;

use App\Http\Resources\Vin\VinResource;
use App\Http\Resources\Part\PartResource;
use App\Http\Resources\Quote\QuoteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class XpartRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'part' => new PartResource($this->part),
            'vin' => new VinResource($this->vin),
            'vendorQuotesCount' => $this->vendorQuotes->count(),
            'quotes' => QuoteResource::collection($this->vendorQuotes),
            'images' => $this->images != null ? $this->images->pluck('file_url') : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
