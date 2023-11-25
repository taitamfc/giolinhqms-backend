<?php

namespace App\Imports;

use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Department;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class DeviceImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    function getDeviceType($name)
    {
        $deviceType = DeviceType::where('name', 'LIKE' , '%'.$name.'%')->first();
        if ($deviceType) {
            return $deviceType->id;
        }else {
            $data['name'] = $name;
            $item = DeviceType::create($data);
            return $item->id;
        }
    }

    function getDepartmant($name)
    {
        $department = Department::where('name', 'LIKE' , '%'.$name.'%')->first();
        if ($department) {
            return $department->id;
        }else {
            $data['name'] = $name;
            $item = Department::create($data);
            return $item->id;
        }
    }
    
    public function collection(Collection $rows)
    {
        $rows->shift();
        Validator::make($rows->toArray(), [
            '*.1' => 'required',
            '*.4' => 'required|numeric',
            '*.8' => 'required',
            '*.9' => 'required',
        ],[
            '*.1.required' => 'Tên thiết bị hàng :attribute là bắt buộc.',
            '*.4.required' => 'Số lượng hàng :attribute là bắt buộc.',
            '*.4.numeric' => 'Số lượng hàng :attribute phải là một số.',
            '*.8.required' => 'Thể loại hàng :attribute thiết bị là bắt buộc.',
            '*.9.required' => 'Bộ môn là hàng :attribute bắt buộc.',
        ])->validate();

        foreach ($rows as $row) {
            $data = [
                'name' => $row[1],
                'country'=>$row[2],
                'year'=>$row[3],
                'quantity'=>$row[4],
                'unit'=>$row[5],
                'price'=>$row[6],
                'note'=>$row[7],
                'device_type_id'=>$this->getDeviceType($row[8]),
                'department_id'=>$this->getDepartmant($row[9]),
            ];
            $item = Device::where('name', 'LIKE', $data['name'])->first();
            if ($item) {
                $item->update($data);
            }else {
                Device::create($data);
            }
        }
    }
}