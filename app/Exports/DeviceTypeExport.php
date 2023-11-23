<?php

namespace App\Exports;

use App\Models\DeviceType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DeviceTypeExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DeviceType::all();
    }
    public function headings(): array {
        return [
            'ID',
            'Loại thiết bị',
            
        ];
    }
 
    public function map($user): array {
        return [
            $user->id,
            $user->name,
        ];
    }
}