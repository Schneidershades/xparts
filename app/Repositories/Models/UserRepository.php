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
        
        return User::query()
                ->selectRaw('users.*')
                ->when($search_query, function (Builder $builder, $search_query) {
                    $builder->where('users.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.phone', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.role', "%{$search_query}%")
                    ->orWhere('users.email', 'LIKE', "%{$search_query}%");
                })->latest();
    }
}