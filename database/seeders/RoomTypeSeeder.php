<?php

namespace Database\Seeders;

use App\Enums\RoomTypeStatus;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create([
            'name' => 'Queen',
            'status' => RoomTypeStatus::ACTIVE,
        ]);
        RoomType::create([
            'name' => 'King',
            'status' => RoomTypeStatus::ACTIVE,
        ]);
        RoomType::create([
            'name' => 'Single',
            'status' => RoomTypeStatus::ACTIVE,
        ]);
        RoomType::create([
            'name' => 'Double',
            'status' => RoomTypeStatus::ACTIVE,
        ]);
    }
}
