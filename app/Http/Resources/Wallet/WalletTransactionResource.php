<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'receipt_number' => $this->receipt_number,
            'title' => $this->title,
            'details' => $this->details,
            'amount' => $this->amount,
            'amount_paid' => $this->amount_paid,
            'category' => $this->category,
            'remarks' => $this->remarks,
            'transaction_type' => $this->transaction_type,
            'status' => $this->status,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}