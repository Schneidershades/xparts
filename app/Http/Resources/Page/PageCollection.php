<?php

namespace App\Http\Resources\Page;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => PageResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'name' => 'name',
            'excerpt' => 'excerpt',
            'slug' => 'slug',
            'content' => 'content',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'name' => 'name',
            'excerpt' => 'excerpt',
            'slug' => 'slug',
            'content' => 'content',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
