<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Wallet\WalletTransactionResource;
use App\Http\Resources\Wallet\WalletTransactionCollection;

class WalletTransaction extends Model
{
    use HasFactory;

    public $oneItem = WalletTransactionResource::class;
    public $allItems = WalletTransactionCollection::class;

    protected $fillable = [
        'receipt_number',
        'title',
        'user_id',
        'details',
        'amount',
        'amount_paid',
        'category',
        'remarks',
        'status',
        'transaction_type',
        'balance',
        'walletable_type',
        'walletable_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }
}
