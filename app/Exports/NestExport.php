<?php

namespace App\Exports;

use App\Models\Nest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NestExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Nest::all();
    }
    public function headings(): array {
        return [
            'ID',
            'Tên',
        ];
    }
 
    public function map($user): array {
        return [
            $user->id,
            $user->name,
        ];
    }
}