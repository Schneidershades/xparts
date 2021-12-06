<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
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
            'data' => OrderResource::collection($this->collection),
            
            'processThrough' => [
                'model' => 'Order',
                'export' => 'OrderExport',
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'id' => 'id',
            'receipt_number' => 'receipt_number',
            'title' => 'title',
            'details' => 'details',
            'subtotal' => 'subtotal',
            'total' => 'total',
            'amount_paid' => 'amount_paid',
            'category' => 'category',
            'remarks' => 'remarks',
            'transaction_type' => 'transaction_type',
            'status' => 'status',
            'payment_status' => 'payment_status',
            'date_cancelled' => 'date_cancelled',
            'cancelled_cancel' => 'cancelled_cancel',
            'platform_initiated' => 'platform_initiated',
            'payment_gateway' => 'payment_gateway',
            'payment_method_id' => 'payment_method_id',
            'service_status' => 'service_status',
            'created_at' => 'created_at',
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
            'subtotal' => 'subtotal',
            'total' => 'total',
            'amount_paid' => 'amount_paid',
            'category' => 'category',
            'remarks' => 'remarks',
            'transaction_type' => 'transaction_type',
            'status' => 'status',
            'payment_status' => 'payment_status',
            'date_cancelled' => 'date_cancelled',
            'cancelled_cancel' => 'cancelled_cancel',
            'platform_initiated' => 'platform_initiated',
            'payment_gateway' => 'payment_gateway',
            'payment_method_id' => 'payment_method_id',
            'service_status' => 'service_status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}