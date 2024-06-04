<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'detail' => fake()->paragraphs(3, true),
            'payment_date' => fake()->date(),
            'payment_balance' => fake()->randomFloat(2, 10, 1000),
            'order_id' => Order::factory()
        ];
    }
}
