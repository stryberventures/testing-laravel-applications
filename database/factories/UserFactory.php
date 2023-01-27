<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            User::COLUMN_FIRSTNAME => fake()->firstName,
            User::COLUMN_LASTNAME => fake()->lastName,
            User::COLUMN_USERNAME => fake()->userName,
            User::COLUMN_EMAIL => fake()->unique()->safeEmail(),
            // Password hashing is slow (by design), especially if you create lots of them in your seeders.
            // You could also hard-code password values to avoid the hashing altogether.
            User::COLUMN_PASSWORD => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            User::COLUMN_IMAGE => fake()->image,
            User::COLUMN_GROUP_ID => Group::factory(),
        ];
    }
}
