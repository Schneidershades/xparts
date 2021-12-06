<?php

namespace App\Http\Resources\Quote;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuoteCollection extends ResourceCollection
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
            'data' => QuoteResource::collection($this->collection),

            'processThrough' => [
                'model' => 'Quote',
                'export' => 'QuoteExport',
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'xpart_request_id' => 'xpart_request_id',
            'vendor_id' => 'vendor_id',
            'part_grade_id' => 'part_grade_id',
            'part_category_id' => 'part_category_id',
            'part_condition_id' => 'part_condition_id',
            'part_subcategory_id' => 'part_subcategory_id',
            'brand' => 'brand',
            'quantity' => 'quantity',
            'part_number' => 'part_number',
            'part_warranty' => 'part_warranty',
            'price' => 'price',
            'description' => 'description',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

     public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'xpart_request_id' => 'xpart_request_id',
            'vendor_id' => 'vendor_id',
            'part_grade_id' => 'part_grade_id',
            'part_category_id' => 'part_category_id',
            'part_condition_id' => 'part_condition_id',
            'part_subcategory_id' => 'part_subcategory_id',
            'brand' => 'brand',
            'quantity' => 'quantity',
            'part_number' => 'part_number',
            'part_warranty' => 'part_warranty',
            'price' => 'price',
            'description' => 'description',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
