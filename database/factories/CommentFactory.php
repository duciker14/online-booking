<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement(User::where('role', UserRole::TOURIST)->pluck('id')),
            'post_id' => $this->faker->randomElement(Post::pluck('id')),
            'comment' =>  $this->faker->text(),
        ];
    }
}
