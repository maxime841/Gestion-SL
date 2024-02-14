<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" =>fake()->text(),
            "content" => fake()->text(),
            "commentable_id" => fake()->numberBetween(1, 5),
            "commentable_type" => fake()->text(),
            "user_id" => fake()->numberBetween(1, 5),
        ];
    }
}
