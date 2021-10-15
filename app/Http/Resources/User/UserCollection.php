<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => UserResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'identifier' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'gender' => 'gender',
            'phone' => 'phone',
            'role' => 'role',
            'status' => 'status',
            'referral_code' => 'referral_code',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'identifier' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'gender' => 'gender',
            'phone' => 'phone',
            'role' => 'role',
            'status' => 'status',
            'referral_code' => 'referral_code',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}