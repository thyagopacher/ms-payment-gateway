<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Pix;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pix>
 */
class PixFactory extends Factory
{

    protected $model = Pix::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pix_key' => fake()->unique()->regexify('[A-Za-z0-9]{20}'),
            'payment_id' => Payment::factory()->state([
                'payment_method' => 'pix',
            ]),
            'status' => fake()->randomElement(['pending', 'paid', 'failed', 'reversed']),
            'amount' => fake()->randomFloat(2, 0.01, 99999.99),
            'bank_id' => Bank::factory(),
        ];
    }
}
