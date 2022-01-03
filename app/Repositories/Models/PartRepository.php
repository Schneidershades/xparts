<?php

namespace App\Repositories\Models;

use App\Models\Part;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class PartRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        $search_query = request()->get('search') ? request()->get('search') : null;
        
        return Part::query()
                ->selectRaw('parts.*')
                ->selectRaw('COUNT(quotes.part_id) as number_of_delivered_quotes')
                ->where('quotes.status', '==', 'delivered')
                ->leftJoin('quotes', 'quotes.part_id', '=', 'parts.id')
                ->groupBy('parts.id')
                ->when($search_query, function (Builder $builder, $search_query) {
                    $builder->where('part.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('part.slug', 'LIKE', "%{$search_query}%");
                })->latest();
    }
}