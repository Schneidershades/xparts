<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, ShouldAutoSize, WithMapping
{
    use Exportable;

    public function collection()
    {
        return User::all();
    }

    public function map($user) : array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role,
            $user->xpartRequests->count() > 0 ? $user->xpartRequests->count() : 0,
        ];
    }
}
