<?php

namespace Database\Seeders;

use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        User::create([
            'name' => 'Nguyễn Văn Hoài',
            'email' => 'nguyenvanhoai1280@gmail.com',
            'password' => Hash::make('admin123'),
            'gender' => UserGender::MALE,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address(),
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ENABLED,
        ]);
        User::create([
            'name' => 'Nguyễn Văn Hoài',
            'email' => 'hoainguyenht12@gmail.com',
            'password' => Hash::make('admin123'),
            'gender' => UserGender::MALE,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address(),
            'role' => UserRole::MANAGER,
            'status' => UserStatus::ENABLED,
        ]);
        User::create([
            'name' => 'Nguyễn Hoàng Minh',
            'email' => 'hoangminh220498@gmail.com',
            'password' => Hash::make('admin123'),
            'gender' => UserGender::MALE,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address(),
            'role' => UserRole::MANAGER,
            'status' => UserStatus::ENABLED,
        ]);
        User::create([
            'name' => 'Hoàng Đình Hợp',
            'email' => 'dinhhop172@gmail.com',
            'password' => Hash::make('admin123'),
            'gender' => UserGender::MALE,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address(),
            'role' => UserRole::MANAGER,
            'status' => UserStatus::ENABLED,
        ]);
        User::create([
            'name' => 'Nguyễn Quang Đức',
            'email' => 'duciker14@gmail.com',
            'password' => Hash::make('admin123'),
            'gender' => UserGender::MALE,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address(),
            'role' => UserRole::MANAGER,
            'status' => UserStatus::ENABLED,
        ]);
        User::create([
            'name' => 'Lương Minh Dương',
            'email' => 'duong40541@gmail.com',
            'password' => Hash::make('admin123'),
            'gender' => UserGender::MALE,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address(),
            'role' => UserRole::MANAGER,
            'status' => UserStatus::ENABLED,
        ]);
        User::factory()->count(50)->create();
    }
}
