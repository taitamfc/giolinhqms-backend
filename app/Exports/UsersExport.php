<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('nest', 'group')->get();
    }
    public function headings(): array {
        return [
            'ID',
            'Tên',
            'Email',    
            "Địa chỉ",
            "Số điện thoại",
            "Giới tính",
            "Ngày sinh",
            "Nhóm",
            "Tổ",
            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
    }
 
    public function map($user): array {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->address,
            $user->phone,
            $user->gender,
            $user->birthday,
            $user->group->name,
            $user->nest->name,
        ];
    }
}