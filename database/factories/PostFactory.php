<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement(User::where('role', UserRole::MANAGER)->pluck('id')),
            'title' => $this->faker->text(100),
            'content' =>  $this->faker->text(1000),
            'views' => rand(10, 1000),
            'status' => rand(PostStatus::PUBLISHED, PostStatus::DRAFT),
        ];
    }
}
