<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\RetailOutlet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->randomNumber(2),
            'total_price' => fake()->randomFloat(2, 1, 100),
            'description' => fake()->paragraphs(1, true),
            'product_id' => Product::factory(),
            'retail_outlet_id' => RetailOutlet::factory()
        ];
    }
}
