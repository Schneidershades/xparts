<?

namespace App\Services;

use App\Repositories\Models\WalletRepository;

class WalletService 
{
    public function checkBalance($user, $amount)
    {
        $wallet = $this->getWalletRepository()->findWallet($user->id);

        if($wallet ==  null){
            return false;
        }

        if($wallet < $amount){
            return false;
        }

        return true;
    }


    protected function getWalletRepository() : WalletRepository
    {
        return new WalletRepository();
    }
}