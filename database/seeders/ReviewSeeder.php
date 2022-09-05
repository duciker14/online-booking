<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', UserRole::TOURIST)->paginate(10);
        $hotels = Hotel::pluck('id');
        $faker = Factory::create();

        foreach ($users as $user) {
            foreach ($hotels as $hotel) {
                Review::firstOrCreate([
                    'user_id' => $user->id,
                    'hotel_id' => $hotel,
                ], [
                    'rate' => rand(3, 5),
                    'content' => $faker->text(),
                ]);
            }
        }
    }
}
