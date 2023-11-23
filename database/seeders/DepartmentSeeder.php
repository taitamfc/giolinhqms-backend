<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'name' 	=> 'Toán'
            ],
            [
                'name' 	=> 'Văn',
            ]
        ];
        foreach ($options as $option) {
            DB::table('departments')->insert($option);
        }
    }
}