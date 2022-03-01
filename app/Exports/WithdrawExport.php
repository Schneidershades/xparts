<?php

namespace App\Exports;

use App\Models\WalletTransaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WithdrawExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return WalletTransaction::where('category','debit')->get();
    }

    public function map($withdrawTransaction) : array
    {
        return [
            $withdrawTransaction->id,
            $withdrawTransaction->user->name,
            $withdrawTransaction->user->email,
            $withdrawTransaction->user->phone,
            $withdrawTransaction->receipt_number,
            $withdrawTransaction->title,
            $withdrawTransaction->walletable_type,
            $withdrawTransaction->amount,
            $withdrawTransaction->amount_paid,
            $withdrawTransaction->transaction_type,
            $withdrawTransaction->status,
            $withdrawTransaction->balance,
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
