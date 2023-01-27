<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
final class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            Group::COLUMN_NAME => $this->faker->company(),
            Group::COLUMN_CODE => mb_strtoupper($this->faker->unique()->lexify('???')),
        ];
    }
}
