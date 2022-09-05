<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Hotel;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', UserRole::MANAGER)->get();
        $faker = Factory::create();

        foreach ($users as $user) {
            Hotel::create([
                'user_id' => $user->id,
                'name' => $faker->name(),
                'address' => $faker->address(),
                'hotline' => $faker->phoneNumber,
                'description' => $faker->text(),
            ]);
        }
    }
}
