<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'total_price' => $this->faker->numberBetween(100000, 5000000),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
        ];
    }
}
