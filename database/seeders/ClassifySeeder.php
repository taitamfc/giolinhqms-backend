<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classify')->insert([
            [
                'name' => 'Thiết bị',
            ],
            [
                'name' => 'Tài sản',
            ],
        ]);
    }
}
