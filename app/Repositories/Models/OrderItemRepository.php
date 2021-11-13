<?

namespace App\Repositories\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class OrderItemRepository implements ApplicationRepository
{
    public function builder(): Builder
    {
        return OrderItem::query();
    }
}