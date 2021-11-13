<?

namespace App\Repositories\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class OrderRepository implements ApplicationRepository
{
    public function builder(): Builder
    {
        return Order::query();
    }
}