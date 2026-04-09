<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{

    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 0.01, 99999999.99),
            'status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'payment_method' => fake()->randomElement(['bank_slip', 'credit_card', 'pix']),
            'person_id' => Person::factory(),
        ];
    }
}
