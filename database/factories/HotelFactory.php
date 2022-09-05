<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id' => User::query()->where('role', UserRole::MANAGER)->inRandomOrder()->value('id'),
            // 'name' => $this->faker->name(),
            // 'address' => $this->faker->address(),
            // 'description' => $this->faker->text(),
        ];
    }
}
