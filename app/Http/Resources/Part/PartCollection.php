<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PartCollection extends ResourceCollection
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
            'data' => PartResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'title' => 'title',
            'image' => 'image',
            'part_number' => 'part_number',
            'overview' => 'overview',
            'slug' => 'slug',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

     public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'title' => 'title',
            'image' => 'image',
            'part_number' => 'part_number',
            'overview' => 'overview',
            'slug' => 'slug',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
