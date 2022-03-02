<?php

namespace App\Exports;

use App\Repositories\Models\WalletTransactionRepository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WalletTransactionExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return (new WalletTransactionRepository())->all();
    }

    public function map($walletTransaction) : array
    {
        return [
            $walletTransaction->id,
            $walletTransaction->user->name,
            $walletTransaction->user->email,
            $walletTransaction->user->phone,
            $walletTransaction->receipt_number,
            $walletTransaction->title,
            $walletTransaction->walletable_type,
            $walletTransaction->amount,
            $walletTransaction->amount_paid,
            $walletTransaction->transaction_type,
            $walletTransaction->status,
            $walletTransaction->balance,
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
            'Wallet type',
            'Amount',
            'Amount paid',
            'Transaction type',
            'Status',
            'Balance',
        ];
    }
}
