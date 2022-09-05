<?php

namespace Database\Factories;

use App\Enums\AffiliatorStatus;
use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address(),
            'birthdate' => $this->faker->dateTimeBetween('-50 years'),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => UserRole::TOURIST,
            'gender' => rand(UserGender::MALE, UserGender::FEMALE),
            'status' => UserStatus::ENABLED,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            if ($user->role == UserRole::TOURIST) {
                $user->is_affiliator = rand(AffiliatorStatus::YES, AffiliatorStatus::NO);
                $user->save();

                $affiliator = Str::random(10);

                if ($user->is_affiliator == AffiliatorStatus::YES) {
                    $user->referen_url = 'http://127.0.0.1:8000/register?affiliator_ref=' .$affiliator;
                    $user->money = rand(500, 3000);
                    $user->save();
                }else{
                    $user->affiliator_ref = $this->faker->randomElement(User::where('is_affiliator', AffiliatorStatus::YES)->pluck('id'));
                    $user->save();
                }
            }
        });
    }
}
