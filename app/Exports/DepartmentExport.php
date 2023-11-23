<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DepartmentExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Department::all();
    }
    public function headings(): array {
        return [
            'ID',
            'Tên bộ môn',
            
        ];
    }
 
    public function map($user): array {
        return [
            $user->id,
            $user->name,
        ];
    }
}