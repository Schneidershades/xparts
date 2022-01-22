<?php

namespace App\Http\Resources\Coupon;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponTransactionResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'percentageDiscount' => $this->percentage,
            'amountDiscount' => $this->amount,
            'start_date' => $this->start_date,
            'expiry_date' => $this->expiry_date,
            'no_of_users' => $this->no_of_users,
            'used' => $this->couponTransactions->count(),
        ];
    }
}
