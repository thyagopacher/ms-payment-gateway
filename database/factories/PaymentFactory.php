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
        $dueDate = fake()->dateTimeBetween('-12 month', '+1 month');
        $paidAt = fake()->optional()->dateTimeBetween($dueDate, '+2 month');
        $status = $paidAt ? 'paid' : fake()->randomElement(['pending', 'failed']);

        return [
            'amount' => fake()->randomFloat(2, 0.01, 99999999.99),
            'status' => $status,
            'payment_method' => fake()->randomElement(['bank_slip', 'credit_card', 'pix']),
            'paid_at' => $paidAt ? $paidAt->format('Y-m-d') : null,
            'due_date' => $dueDate->format('Y-m-d'),
            'person_id' => Person::factory(),
        ];
    }
}
