<?php

namespace App\Repositories\Models;

use App\Models\XpartRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class XpartRequestRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        $search_query = request()->get('search') ? request()->get('search') : null;

        return XpartRequest::query()
                    ->selectRaw('xpart_requests.*')
                    ->selectRaw('users.name AS user_name')
                    ->selectRaw('parts.name AS part_name')
                    ->selectRaw('vins.vin_number AS vin_number')
                    ->leftJoin('users', 'users.id', '=', 'xpart_requests.user_id')
                    ->leftJoin('parts', 'parts.id', '=', 'xpart_requests.part_id')
                    ->leftJoin('addresses', 'addresses.id', '=', 'xpart_requests.address_id')
                    ->leftJoin('vins', 'vins.id', '=', 'xpart_requests.vin_id')
                    ->when($search_query, function (Builder $builder, $search_query) {
                        $builder->where('vin_number', 'LIKE', "%{$search_query}%")
                        ->orWhere('users.name', 'LIKE', "%{$search_query}%")
                        ->orWhere('parts.name', 'LIKE', "%{$search_query}%")
                        ->orWhere('xpart_requests.id', 'LIKE', "%{$search_query}%")
                        ->orWhere('xpart_requests.status', 'LIKE', "%{$search_query}%");
                    })->latest();
    }

    public function findWallet($userId)
    {
        return XpartRequest::where('user_id', $userId)->first();
    }
}