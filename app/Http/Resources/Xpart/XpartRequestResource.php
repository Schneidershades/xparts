<?php

namespace App\Http\Resources\Xpart;

use App\Http\Resources\Vin\VinResource;
use App\Http\Resources\Part\PartResource;
use App\Http\Resources\Quote\QuoteResource;
use App\Http\Resources\Address\AddressResource;
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
            'address' => new AddressResource($this->address),
            'receipt_number_details' => $this->receipt_number ? $this->receipt_number : 'N/A',
            'receipt_number' => $this->receipt_number,
            'status' => $this->status,
            'user_description' => $this->user_description,
            'admin_description' => $this->admin_description,
            'customer_amount_to_pay' => $this->order ? $this->order->amount_paid : 'No orders placed yet',
        ];
    }
}
