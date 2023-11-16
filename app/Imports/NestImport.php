<?php

namespace App\Imports;

use App\Models\Nest;
use Maatwebsite\Excel\Concerns\ToModel;

class NestImport implements ToModel
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
        $existingUser = Nest::where('name', $row[1])->first();
        if ($existingUser) {
            return null;
        }
        return new Nest([
            'name'=>$row[1],
            ]);
    }
}