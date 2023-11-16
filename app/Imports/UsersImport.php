<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * 
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
        $existingUser = User::where('email', $row[2])->first();
        if ($existingUser) {
            return null;
        }
        return new User([
            'name'=>$row[1],
            'email'=>$row[2], 
            'password'=>Hash::make($row[3]),
            'address'=>$row[4], 
            'phone'=>$row[5], 
            'gender'=>$row[6], 
            'birthday' => date('Y-m-d', strtotime($row[7])),
            'group_id'=>$row[8], 
            'nest_id'=>$row[9], 
            ]);
    }
}