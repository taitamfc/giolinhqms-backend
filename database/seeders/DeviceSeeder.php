<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('devices')->insert([
            [
                'name' => 'Máy đo vận tốc',
                'device_type_id' => 1,
                'department_id' => 1,
                'quantity' => 5,
                'image' => 'device1.jpg',
                'year_born' => 1990,
                'unit' => 'Cái',
                'note' => 10,
                'classify_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}