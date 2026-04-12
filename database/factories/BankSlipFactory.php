<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\BankSlip;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BankSlip>
 */
class BankSlipFactory extends Factory
{

    protected $model = BankSlip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_name' => fake()->name(),
            'person_city' => fake()->city(),
            'person_uf' => fake()->stateAbbr(),
            'person_cpf_cnpj' => fake()->numerify('###########'),
            'person_address' => fake()->streetAddress(),
            'person_zipcode' => fake()->postcode(),
            'bill_amount' => fake()->randomFloat(2, 0.01, 99999999.99),
            'bill_due_date' => fake()->date('Y-m-d'),
            'payment_id' => Payment::factory()->state([
                'payment_method' => 'bank_slip',
            ]),
            'bank_id' => Bank::factory(),
        ];
    }
}
