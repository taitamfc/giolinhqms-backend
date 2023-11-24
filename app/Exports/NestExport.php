<?php

namespace App\Exports;

use App\Models\Nest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NestExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize, WithStyles
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
 
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
    }
    
    public function map($user): array {
        return [
            $user->id,
            $user->name,
        ];
    }
}