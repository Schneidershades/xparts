<?php

namespace App\Repositories\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class UserRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        $search_query = request()->get('search') ? request()->get('search') : null;

        $sort = request()->get('sort_by') ? request()->get('sort_by') : null;

        return User::query()
                ->selectRaw('users.*')
                ->selectRaw('wallets.balance AS balance')
                ->selectRaw('COUNT(quotes.vendor_id) as number_of_quotes')
                ->where('users.role', '!=', 'Admin')
                ->join('wallets', 'wallets.user_id', '=', 'users.id')
                ->leftJoin('quotes', 'quotes.vendor_id', '=', 'users.id')
                ->groupBy('users.id')
                ->when($search_query, function (Builder $builder, $search_query) {
                    $builder->where('users.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.phone', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.role', "%{$search_query}%")
                    ->orWhere('users.email', 'LIKE', "%{$search_query}%");
                })->dateFilter(request()->get('date'))->latest();
    }
}
