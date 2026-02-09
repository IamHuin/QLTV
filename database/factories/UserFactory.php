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
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt($this->faker->password()),
            'email' => $this->faker->unique()->safeEmail(),
            'otp_code' => null,
            'otp_expires' => null,
            'email_verified_at' => now(),
        ];
    }
}
