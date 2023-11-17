<?php

namespace App\Imports;

use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Department;
use App\Models\Classify;
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
        return $deviceType ? $deviceType->id : null;
    }
    function getClassify($name)
    {
        $classify = Classify::where('name', 'LIKE' , '%'.$name.'%')->first();
        return $classify ? $classify->id : null;
    }

    function getDepartmant($name)
    {
        $department = Department::where('name', 'LIKE' , '%'.$name.'%')->first();
        return $department ? $department->id : null;
    }
    
    public function collection(Collection $rows)
    {
        $rows->shift();
        Validator::make($rows->toArray(), [
            '*.1' => 'required|unique:devices,name',
            '*.4' => 'required|numeric',
            '*.8' => 'required',
            '*.9' => 'required',
            '*.10' => 'required',
        ],[
            '*.1.required' => 'Tên thiết bị hàng :attribute là bắt buộc.',
            '*.1.unique' => 'Tên thiết bị hàng :attribute đã tồn tại.',
            '*.4.required' => 'Số lượng hàng :attribute là bắt buộc.',
            '*.4.numeric' => 'Số lượng hàng :attribute phải là một số.',
            '*.8.required' => 'Thể loại hàng :attribute thiết bị là bắt buộc.',
            '*.9.required' => 'Bộ môn là hàng :attribute bắt buộc.',
            '*.10.required' => 'Phân loại hàng :attribute là bắt buộc.',
        ])->validate();

        foreach ($rows as $row) {
            Device::create([
                'name' => $row[1],
                'country'=>$row[2],
                'year_born'=>$row[3],
                'quantity'=>$row[4],
                'unit'=>$row[5],
                'price'=>$row[6],
                'note'=>$row[7],
                'device_type_id'=>$this->getDeviceType($row[8]),
                'department_id'=>$this->getDepartmant($row[9]),
                'classify_id'=>$this->getClassify($row[10]),
            ]);
        }
    }
}