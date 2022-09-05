<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            HotelSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
            PaymentRequestSeeder::class,
            ReviewSeeder::class,
            CategorySeeder::class,
            CategoryHotelSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
