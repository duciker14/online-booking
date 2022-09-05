<?php

namespace Database\Factories;

use App\Enums\RoomStatus;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hotel_id' => Hotel::query()->inRandomOrder()->value('id'),
            'room_type_id' => RoomType::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->name(),
            'price' => rand(100, 3000),
            'status' => RoomStatus::AVAILABLE,
        ];
    }
}
