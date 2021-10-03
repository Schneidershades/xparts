<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletTransactionCollection extends ResourceCollection
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
            'data' => WalletTransactionResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'receipt_number' => 'receipt_number',
            'title' => 'title',
            'details' => 'details',
            'amount' => 'amount',
            'amount_paid' => 'amount_paid',
            'category' => 'category',
            'remarks' => 'remarks',
            'transaction_type' => 'transaction_type',
            'status' => 'status',
            'balance' => 'balance',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'receipt_number' => 'receipt_number',
            'title' => 'title',
            'details' => 'details',
            'amount' => 'amount',
            'amount_paid' => 'amount_paid',
            'category' => 'category',
            'remarks' => 'remarks',
            'transaction_type' => 'transaction_type',
            'status' => 'status',
            'balance' => 'balance',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
