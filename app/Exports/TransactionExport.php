<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }

    public function map($orderTransaction) : array
    {
        return [
            $orderTransaction->id,
            $orderTransaction->user->name,
            $orderTransaction->user->email,
            $orderTransaction->user->phone,
            $orderTransaction->receipt_number,
            $orderTransaction->title,
            $orderTransaction->payment_method,
            $orderTransaction->total,
            $orderTransaction->amount_paid,
            $orderTransaction->subtotal,
            $orderTransaction->status,
            $orderTransaction->payment_gateway,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Phone',
            'Receipt number',
            'Title',
            'Payment method',
            'Total',
            'Amount paid',
            'Subtotal',
            'Status',
            'Payment gateway',
        ];
    }
}
