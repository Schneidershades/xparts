<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Address\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Payment\PaymentChargeResource;
use App\Http\Resources\Payment\PaymentMethodResource;
use App\Models\PaymentMethod;

class OrderResource extends JsonResource
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
            'receipt_number' => $this->receipt_number,
            'title' => $this->title,
            'details' => $this->details,
            'user_id' => $this->user_id,
            'address' => new AddressResource($this->address),
            'vat_id' => $this->vat_id,
            'discount_id' => $this->discount_id,
            'payment_method_id' => $this->payment_method_id,
            'delivery_rate_id' => $this->delivery_rate_id,
            'delivery_fee' => $this->deliveryRate ? $this->deliveryRate->amount : null,
            'payment_method' => new PaymentMethod($this->paymentMethod),
            'charge' => new PaymentChargeResource($this->paymentCharge),
            'subtotal' => $this->subtotal,
            'orderable_type' => $this->orderable_type,
            'orderable_id' => $this->orderable_id,
            'total' => $this->total,
            'amount_paid' => $this->amount_paid,
            'discount_amount' => $this->discount_amount,
            'action' => $this->action,
            'currency_id' => $this->currency_id,


            'payment_transfer_status' => $this->payment_transfer_status,
            'payment_recipient_code' => $this->payment_recipient_code,
            'payment_transfer_code' => $this->payment_transfer_code,
            'payment_transfer_remarks' => $this->payment_transfer_remarks,
            'payment_gateway_remarks' => $this->payment_gateway_remarks,
            'payment_charge_id' => $this->payment_charge_id,

            'currency' => $this->currency,
            'payment_gateway' => $this->payment_gateway,
            'payment_gateway_charged_percentage' => $this->payment_gateway_charged_percentage,
            'payment_gateway_expected_charged_percentage' => $this->payment_gateway_expected_charged_percentage,
            'payment_reference' => $this->payment_reference,
            'payment_gateway_charge' => $this->payment_gateway_charge,
            'payment_gateway_remittance' => $this->payment_gateway_remittance,
            'payment_code' => $this->payment_code,
            'payment_message' => $this->payment_message,
            'payment_status' => $this->payment_status,
            'platform_initiated' => $this->platform_initiated,
            'transaction_initiated_date' => $this->transaction_initiated_date,
            'transaction_initiated_time' => $this->transaction_initiated_time,
            'date_time_paid' => $this->date_time_paid,
            'date_cancelled' => $this->date_cancelled,
            'cancelled_cancel' => $this->cancelled_cancel,
            'service_status' => $this->service_status,
            'status' => $this->status,
            'transaction_type' => $this->transaction_type,
            'items' => OrderItemResource::collection($this->orderItems),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}