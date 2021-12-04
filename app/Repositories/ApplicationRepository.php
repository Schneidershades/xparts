<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lerouse\LaravelRepository\EloquentRepository;

abstract class ApplicationRepository extends EloquentRepository
{
    public function __construct()
    {
        $this->paginationLimit = config('app.pagination_limit');
    }

    public function paginate(int $limit = null): LengthAwarePaginator
    {
        $page = optional(request())->get('page') ?? 1;

        return $this->builder()->paginate(
            $limit ?? $this->paginationLimit, ['*'], 'page', $page
        );
    }

}
