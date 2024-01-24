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
            "commentaire" => fake()->text(),
            //"parent_id" => fake()->numberBetween(0, 1000000),
           // "user_id" => fake()->numberBetween(0, 1000000),
            "commentable_id" => fake()->numberBetween(0, 1000000),
            "commentable_type" => fake()->text()
        ];
    }
}
