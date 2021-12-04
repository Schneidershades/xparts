<?php

namespace App\Repositories\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class OrderRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        $search_query = request()->get('search') ? request()->get('search') : null;
        
        return Order::query()
                    ->selectRaw('orders.*')
                    ->when($search_query, function (Builder $builder, $search_query) {
                        $builder->where('orders.id', 'LIKE', "%{$search_query}%")
                        ->orWhere('orders.receipt_number', 'LIKE', "%{$search_query}%")
                        ->orWhere('orders.status', 'LIKE', "%{$search_query}%")
                        ->orWhere('orders.title', 'LIKE', "%{$search_query}%");
                    })->latest();
    }
}