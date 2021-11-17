<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\XpartRequest;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{
    public function search()
    {
        // $results = Search::add(
        //     XpartRequest::where('vin.name', )->orWhere(), ['receipt_number'], 'updated_at')
        //     ->get('search');
    }
}
