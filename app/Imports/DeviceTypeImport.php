<?php

namespace App\Imports;

use App\Models\DeviceType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class DeviceTypeImport implements ToCollection
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
            '*.1' => 'required|unique:device_types,name',
        ],[
            '*.1.required' => 'Loại thiết bị hàng :attribute là bắt buộc.',
            '*.1.unique' => 'Loại thiết bị hàng :attribute đã tồn tại.',
        ])->validate();

        foreach ($rows as $row) {
            DeviceType::create([
                'name' => $row[1],
            ]);
        }
    }
}