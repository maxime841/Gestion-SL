<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" =>fake()->name(),
            "owner" => fake()->name(),
            "presentation" =>fake()->text(),
            "description" =>fake()->text(),
            "price" => fake()->randomDigitNotNull(),
            "tag" => fake()->text()
        ];
    }
}
