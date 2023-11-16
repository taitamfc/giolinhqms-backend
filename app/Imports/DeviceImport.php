<?php

namespace App\Imports;

use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;

class DeviceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $skipRows = 1; // Số hàng tiêu đề cần bỏ qua

    function getDeviceType($name)
    {
        $deviceType = DeviceType::where('name', $name)->first();
        return $deviceType ? $deviceType->id : null;
    }

    function getDepartmant($name)
    {
        $department = Department::where('name', $name)->first();
        return $department ? $department->id : null;
    }

    public function model(array $row)
    {
        // bỏ qua hàng tiêu đề
        if ($this->skipRows > 0) {
            $this->skipRows--;
            return null;
        }
        // bỏ qua nếu email trùng
        $existingUser = Device::where('name', $row[1])->first();
        if ($existingUser) {
            return null;
        }
        return new Device([
            'name'=>$row[1],
            'country'=>$row[2],
            'year_born'=>$row[3],
            'quantity'=>$row[4],
            'unit'=>$row[5],
            'price'=>$row[6],
            'note'=>$row[7],
            'device_type_id'=>$this->getDeviceType($row[8]),
            'department_id'=>$this->getDepartmant($row[9]),
            'classify'=>$row[10],
        ]);
    }
}