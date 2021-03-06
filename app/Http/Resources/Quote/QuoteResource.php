<?php

namespace App\Http\Resources\Quote;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\VendorResource;
use App\Http\Resources\Address\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Xpart\XpartRequestResource;

class QuoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'xpartRequestPart' => $this->xpartRequest ? $this->xpartRequest->part->name : null,
            'xpartRequestVin' => $this->xpartRequest ? $this->xpartRequest->vin->vin_number : null,
            'receipt_number_details' => $this->receipt_number ? $this->receipt_number : 'N/A',
            'receipt_number' => $this->receipt_number,
            'vendor' => new VendorResource($this->vendor),
            'grade' => $this->partGrade->name,
            'brand' => $this->brand,
            'quantity' => $this->quantity,
            'part_number' => $this->part_number,
            'part_warranty' => $this->part_warranty,
            'measurement' => $this->measurement,
            'actual_price' => $this->price ? $this->price : 0,
            'price' => $this->markup_price ? $this->markup_price :  $this->price,
            'description' => $this->description,
            'status' => $this->status,
            'state' => $this->state ? $this->state->name : 'N/A',
            'city' => $this->city ? $this->city->name : 'N/A',
            'country' => $this->country ? $this->country->name : 'N/A',
            'images' => $this->images != null ? $this->images->pluck('file_url') : null,
            'markup_price' => $this->markup_price ? $this->markup_price : 0,
            'markup_price_details' => $this->markupPricing,
            'price_margin' => ($this->markup_price - $this->price),
            'userOrderDetails' => $this->order ? new UserResource($this->order->user) : 'user not available',
            'address' => $this->order ? new AddressResource($this->order->address) : 'address not available',
            'customer_amount_to_pay' => $this->order ? $this->order->amount_paid : 'No orders placed yet',
            'margin' => $this->margin,
            'delivery_fee' => $this->delivery_fee,
            'extra_fee_cost' => $this->extra_fee_cost,
            'extra_fee_description' => $this->extra_fee_description,
            'admin_id' => $this->admin_id,
            'approving_admin_id' => $this->approving_admin_id,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            $this->mergeWhen($this->status == 'delivered', [
                'available_statuses' => [
                    [
                        'key' => 'refunded',
                        'message' => 'Refund user'
                    ],
                ],
            ]),

            $this->mergeWhen($this->status == 'active' || $this->status == 'ordered' , [
                'available_statuses' => [
                    [
                        'key' => 'expired',
                        'message' => 'Expired'
                    ],
                    [
                        'key' => 'delivered',
                        'message' => 'Delivered'
                    ],
                ],
            ]),

            $this->mergeWhen($this->status == 'expired', [
                'available_statuses' => [
                    [
                        'key' => 'none',
                        'message' => 'you cannot process any status',
                    ],
                ],
            ]),

            $this->mergeWhen($this->status == 'pending' || $this->status == 'paid' || $this->status == 'vendor2xparts', [
                'available_statuses' => [
                    [
                        'key' => 'delivered',
                        'message' => 'Delivered',
                        'credit_user_wallet_action' => false,
                        'credit_vendor_wallet_action' => false,
                        'debit_user_wallet_action' => false,
                        'debit_vendor_wallet_action' => false,
                    ],
                    [
                        'key' => 'refunded',
                        'message' => 'Refunded',
                        'credit_user_wallet_action' => false,
                        'credit_user_wallet_action' => false,
                        'debit_user_wallet_action' => false,
                        'debit_vendor_wallet_action' => false,
                    ],
                    [
                        'key' => 'vendor2xparts',
                        'message' => 'Vendor2xparts',
                        'credit_user_wallet_action' => false,
                        'credit_user_wallet_action' => false,
                        'debit_user_wallet_action' => false,
                        'debit_vendor_wallet_action' => false,
                    ],
                    [
                        'key' => 'expired',
                        'message' => 'Expired',
                        'credit_user_wallet_action' => false,
                        'credit_user_wallet_action' => false,
                        'debit_user_wallet_action' => false,
                        'debit_vendor_wallet_action' => false,
                    ],
                ],
            ]),
        ];
    }
}