<?

namespace App\Repositories\Models;

use App\Models\Wallet;
use App\Repositories\ApplicationRepository;
use Illuminate\Database\Eloquent\Builder;

class WalletRepository implements ApplicationRepository
{
    public function builder(): Builder
    {
        return Wallet::query();
    }

    public function findWallet($userId)
    {
        return Wallet::where('user_id', $userId)->first();
    }
}