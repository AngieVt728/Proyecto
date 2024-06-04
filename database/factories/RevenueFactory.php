<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Revenue>
 */
class RevenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'revenue_date' => fake()->date(),
            'quantity' => fake()->randomNumber(2),
            'description' => fake()->paragraphs(1, true),
            'product_id' => Product::factory()
        ];
    }
}
