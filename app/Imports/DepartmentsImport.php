<?php

namespace App\Imports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;

class DepartmentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $skipRows = 1; // Số hàng tiêu đề cần bỏ qua

    public function model(array $row)
    {
        // bỏ qua hàng tiêu đề
        if ($this->skipRows > 0) {
            $this->skipRows--;
            return null;
        }
        // bỏ qua nếu email trùng
        $existingUser = Department::where('name', $row[1])->first();
        if ($existingUser) {
            return null;
        }
        return new Department([
            'name'=>$row[1],
            ]);
    }
}