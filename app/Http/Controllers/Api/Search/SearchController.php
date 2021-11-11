<?php

namespace App\Http\Controllers\Api\Search;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{
    public function search()
    {
        $results = Search::add(Order::class, ['receipt_number'], 'updated_at')
            ->add(User::class, ['name', 'email'], 'updated_at')
            ->get('search');
    }
}
