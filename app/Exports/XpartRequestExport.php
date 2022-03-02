<?php

namespace App\Exports;

use App\Models\XpartRequest;
use App\Repositories\Models\XpartRequestRepository;
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
//        return XpartRequest::all();
        return (new XpartRequestRepository())->all();
    }

    public function map($xpartRequest) : array
    {
        return [
             $xpartRequest->id,
             $xpartRequest->user->name,
             $xpartRequest->user->email,
             $xpartRequest->user->phone,
             $xpartRequest->vin->vin_number,
             $xpartRequest->status,
             $xpartRequest->receipt_number,
             $xpartRequest->user_description,
        ];
    }

    public function headings(): array
    {
        return [
             '#',
             'Name',
             'Email',
             'Phone',
             'Vin',
             'Status',
             'Receipt number',
             'User description',
        ];
    }
}
