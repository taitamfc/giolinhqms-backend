<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DevicesExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Device::with('devicetype','department','classify')->get();
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
            $user->classify->name,
        ];
    }
}