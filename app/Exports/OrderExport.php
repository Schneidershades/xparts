<?php

namespace App\Exports;

use App\Models\Order;
use App\Repositories\Models\OrderRepository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;
    
    public function collection()
    {
        return (new OrderRepository())->all();
    }

    public function map($order) : array
    {
        return [
             $order->id,
             $order->name,
             $order->email,
             $order->phone,
             $order->role,
             $order->xpartRequests->count() > 0 ? $order->xpartRequests->count() : 0,
             $order->quotes->count() > 0 ? $order->quotes->count() : 0,
             $order->wallet->balance,
        ];
    }

    public function headings(): array
    {
        return [
             '#',
             'Name',
             'Email',
             'Phone',
             'Role',
             'Xpart Requests',
             'Quotes',
             'Balance (N)',
        ];
    }
}
