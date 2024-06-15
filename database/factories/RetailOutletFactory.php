<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RetailOutlet>
 */
class RetailOutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'nit' => fake()->randomNumber(8),
            'description' => fake()->paragraphs(1, true),
            'address' => fake()->address(),
            'lat' => fake()->latitude(),
            'lng' => fake()->longitude(),
            'image' => fake()->imageUrl(),
            'user_id' => User::factory()
        ];
    }
}
