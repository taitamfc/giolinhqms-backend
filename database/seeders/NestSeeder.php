<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nests = [
            ['name' => 'Toán'],
            ['name' => 'Lý'],
            ['name' => 'Hóa'],
            ['name' => 'Sử'],
            ['name' => 'Địa'],
        ];
        DB::table('nests')->insert($nests);
    }
}
