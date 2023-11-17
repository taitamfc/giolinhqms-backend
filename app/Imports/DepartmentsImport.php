<?php

namespace App\Imports;

use App\Models\Department;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartmentsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        // bỏ qua hàng tiêu đề
        $rows->shift();

        // bỏ qua nếu teen trùng
        Validator::make($rows->toArray(), [
            '*.1' => 'required|unique:departments,name',
        ],[
            '*.1.required' => 'Bộ môn hàng :attribute là bắt buộc.',
            '*.1.unique' => 'Bộ môn hàng :attribute đã tồn tại.',
        ])->validate();

        foreach ($rows as $row) {
            Department::create([
                'name' => $row[1],
            ]);
        }
    }
}