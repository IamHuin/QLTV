<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => 2,
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt($this->faker->password()),
            'email' => $this->faker->unique()->safeEmail(),
            'otp_code' => $this->faker->unique()->numberBetween(1000, 9999),
            'otp_expires' => now(),
            'email_verified_at' => now(),
        ];
    }
}
