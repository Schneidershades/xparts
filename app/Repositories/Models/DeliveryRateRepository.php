<?php

namespace App\Repositories\Models;

use App\Models\DeliveryRate;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class OrderItemRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        $search_query = request()->get('search') ? request()->get('search') : null;

        return DeliveryRate::query()
                    ->selectRaw('delivery_rates.*')
                    ->when($search_query, function (Builder $builder, $search_query) {
                        $builder->where('delivery_rates.id', 'LIKE', "%{$search_query}%")
                        ->orWhere('delivery_rates.destinatable_id', 'LIKE', "%{$search_query}%")
                        ->orWhere('delivery_rates.destinatable_type', 'LIKE', "%{$search_query}%");
                    })->latest();
    }

    public function fetchDeliveryRate($id)
    {
        return $this->builder->where('delivery_rates.id', '=', $id)->first();
    }
}