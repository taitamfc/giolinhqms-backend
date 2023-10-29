<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['name' => 'Room 1'],
            ['name' => 'Room 2'],
            ['name' => 'Room 3'],
            ['name' => 'Room 4'],
            ['name' => 'Room 5'],
        ];

        DB::table('rooms')->insert($rooms);
    }
}
