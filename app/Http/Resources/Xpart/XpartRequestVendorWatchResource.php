<?php

namespace App\Http\Resources\Xpart;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Xpart\XpartRequestResource;

class XpartRequestVendorWatchResource extends JsonResource
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
            'status' => $this->status,
            'views' => $this->views,
            'number_of_bids' => $this->number_of_bids,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
