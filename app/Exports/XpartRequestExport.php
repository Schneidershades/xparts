<?php

namespace App\Exports;

use App\Models\XpartRequest;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class XpartRequestExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return XpartRequest::all();
    }

    public function map($user) : array
    {
        return [
            // $user->id,
            // $user->name,
            // $user->email,
            // $user->phone,
            // $user->role,
            // $user->xpartRequests->count() > 0 ? $user->xpartRequests->count() : 0,
            // $user->quotes->count() > 0 ? $user->quotes->count() : 0,
            // $user->wallet->balance,
        ];
    }

    public function headings(): array
    {
        return [
            // '#',
            // 'Name',
            // 'Email',
            // 'Phone',
            // 'Role',
            // 'Xpart Requests',
            // 'Quotes',
            // 'Balance (N)',
        ];
    }
}
