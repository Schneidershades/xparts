<?php

namespace App\Http\Controllers\Api\Export;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function users()
    {
        return (new UsersExport)->download('users.xlsx');
    }

    public function vendor()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function xpartRequests()
    {
        return Excel::download(new UsersExport, 'xpart-request.xlsx');
    }

    public function orders()
    {
        return Excel::download(new UsersExport, 'orders.xlsx');
    }

    public function quotes()
    {
        return Excel::download(new UsersExport, 'orders.xlsx');
    }
}
