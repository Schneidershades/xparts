<?php

namespace App\Http\Resources\Part;

use App\Http\Resources\Part\PartResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PartCollection extends ResourceCollection
{
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
            'name' => 'name',
            'slug' => 'slug',
            'number_of_delivered_quotes' => 'number_of_delivered_quotes',
            
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

     public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'name' => 'name',
            'slug' => 'slug',
            'number_of_delivered_quotes' => 'number_of_delivered_quotes',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
