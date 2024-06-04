<?php

namespace Database\Factories;

use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outflow>
 */
class OutflowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'outflow_date' => fake()->date(),
            'quantity' => fake()->randomNumber(2),
            'raw_material_id' => RawMaterial::factory()
        ];
    }
}
