<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Land>
 */
class LandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'owner' => fake()->name(),
            'presentation' => fake()->text(),
            'description' => fake()->text(),
            'group' => fake()->text(),
            'prims' => fake()->numberBetween(0, 1000000),
            'remaining_prims' => fake()->numberBetween(0, 1000000),
            'date_buy' => fake()->dateTime(),
        ];
    }
}
