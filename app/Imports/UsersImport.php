<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Group;
use App\Models\Nest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;;

class UsersImport implements ToCollection
{
    /**
     * 
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    function getGroup($name)
    {
        $group = Group::where('name', 'LIKE' , '%'.$name.'%')->first();
        // return $group ? $group->id : null;
        if ($group) {
            return $group->id;
        }else {
            $data['name'] = $name;
            $item = Group::create($data);
            return $item->id;
        }
    }
    function getNest($name)
    {
        $nest = Nest::where('name', 'LIKE' , '%'.$name.'%')->first();
        // return $group ? $group->id : null;
        if ($nest) {
            return $nest->id;
        }else {
           $data['name'] = $name;
           $item = Nest::create($data);
           return $item->id;
        };
    }


    public function collection(Collection $rows)
    {
        $rows->shift();
        $rows->pop();
        Validator::make($rows->toArray(), [
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'required',
            '*.4' => 'required',
            '*.5' => 'required',
            '*.8' => 'required',
            '*.9' => 'required',
        ],[
            '*.1.required' => 'Tên người dùng :attribute là bắt buộc.',
            '*.2.required' => 'Email người dùng :attribute là bắt buộc.',
            '*.3.required' => 'Mật khẩu người dùng :attribute là bắt buộc.',
            '*.4.required' => 'Địa chỉ người dùng :attribute là bắt buộc.',
            '*.5.required' => 'Số điện thoại người dùng :attribute là bắt buộc.',
            '*.8.required' => 'Nhóm người dùng :attribute là bắt buộc.',
            '*.9.required' => 'Tổ người dùng :attribute là bắt buộc.',
        ])->validate();

        foreach ($rows as $row) {
            $data = [
                'name'=>$row[1],
                'email'=>$row[2], 
                'password'=>Hash::make($row[3]),
                'address'=>$row[4], 
                'phone'=>$row[5], 
                'gender'=>$row[6], 
                'birthday' => date('Y-m-d', strtotime($row[7])),
                'group_id'=>$this->getGroup($row[8]), 
                'nest_id'=>$this->getNest($row[9]), 
            ];
            $item = User::where('email', 'LIKE', $data['email'])->first();
            if ($item) {
                $item->update($data);
            }else {
                User::create($data);
            }
        }
    }
}