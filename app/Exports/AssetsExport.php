<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetsExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Asset::with('devicetype','department','classify')->get();
    }
    public function headings(): array {
        return [
            'ID',
            'Tên thiết bị',
            'Nước sản xuất',    
            "Năm sản xuất",
            "Số lượng",
            "Đơn vị",
            "Giá",
            "Ghi chú",
            "Loại thiết bị",
            "Bộ môn",
            "Phân loại",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
    }
 
    public function map($user): array {
        return [
            $user->id,
            $user->name,
            $user->country,
            $user->year_born,
            $user->quantity,
            $user->unit,
            $user->price,
            $user->note,
            $user->devicetype->name,
            $user->department->name,
            $user->type,
        ];
    }
}