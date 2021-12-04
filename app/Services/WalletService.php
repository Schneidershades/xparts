<?php

namespace App\Services;

use App\Repositories\Models\WalletRepository;

use App\Services\BaseService;

class WalletService extends BaseService
{
    public function checkUserBalance($user, $amount)
    {
        $wallet = $this->getWalletRepository()->findWallet($user->id);

        if($wallet == null){
            return $this->errorResponse('you have no wallet', 409);
        }

        if($wallet < $amount){
            return $this->errorResponse('insufficient balance', 409);
        }

        return true;
    }


    protected function getWalletRepository() : WalletRepository
    {
        return new WalletRepository();
    }
}