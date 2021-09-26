<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'title',
        'user_id',
        'details',
        'amount',
        'amount_paid',
        'category',
        'remarks',
        'transaction_type',
        'balance',
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
