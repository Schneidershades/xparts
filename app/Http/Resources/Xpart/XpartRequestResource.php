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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            
            // 'status' => $this->status,
            $this->mergeWhen($this->status =='ordered' , [
                'status' => 'ordered',
            ]),

            $this->mergeWhen($this->status =='xparts2user' || $this->status =='vendor2xparts' && auth()->user()->role == 'user', [
                'status' => 'paid',
            ]),

            $this->mergeWhen($this->status == 'delivered' || $this->status == 'awaiting' || $this->status == 'active' || $this->status == 'paid' && auth()->user()->role == 'user', [
                'status' => $this->status,
            ]),

            $this->mergeWhen(auth()->user()->role == 'admin', [
                'status' => $this->status,
            ]),
        ];
    }
}
