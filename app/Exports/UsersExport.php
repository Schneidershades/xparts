<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use App\Repositories\Models\UserRepository;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return (new UserRepository)->all();
    }

    public function map($user) : array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone,
            $user->role,
            $user->xpartRequests->count() > 0 ? $user->xpartRequests->count() : 0,
            $user->quotes->count() > 0 ? $user->quotes->count() : 0,
            $user->wallet->balance ?? '',
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
