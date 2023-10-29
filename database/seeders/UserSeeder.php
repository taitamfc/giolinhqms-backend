<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Quản Trị Viên';
        $user->email = 'admin@gmail.com';
        $user->address = 'DH';
        $user->phone = '0123456789';
        $user->image = '';
        $user->gender = 'Man';
        $user->birthday = '1999-02-20';
        $user->password = Hash::make('123456');
        $user->group_id = 1;
        $user->nest_id = 1;
        $user->save();//1
    }
}
