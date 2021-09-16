<?php

namespace App\Http\Resources\Xpart;

use Illuminate\Http\Resources\Json\ResourceCollection;

class XpartRequestVendorWatchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => XpartRequestVendorWatchResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'xpart_request_id' => 'xpart_request_id',
            'vendor_id' => 'vendor_id',
            'views' => 'views',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'xpart_request_id' => 'xpart_request_id',
            'vendor_id' => 'vendor_id',
            'views' => 'views',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
