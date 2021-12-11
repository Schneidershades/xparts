<?php

namespace App\Repositories\Models;

use App\Models\Wallet;
use App\Repositories\ApplicationRepository;
use Illuminate\Database\Eloquent\Builder;

class WalletRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        return Wallet::query();
    }

    public function findWallet($userId)
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function creditUser($user_id, $amount)
    {  
        $wallet = Wallet::find($user_id);
        $wallet->balance = $wallet->balance + $amount;
        $wallet->save();
        return $wallet;
    }

    public function debitUser($user_id, $amount)
    {  
        $wallet = Wallet::find($user_id);
        $wallet->balance = $wallet->balance - $amount;
        $wallet->save();
        return $wallet;
    }
}