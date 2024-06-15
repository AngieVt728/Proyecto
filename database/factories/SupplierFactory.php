<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nit' => fake()->unique()->randomNumber(8),
            'description' => fake()->paragraphs(1, true),
            'email' => fake()->unique()->safeEmail(),
            'contact' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }
}
