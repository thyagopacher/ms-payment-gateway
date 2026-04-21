<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BankSlipTest extends TestCase
{

    use WithoutMiddleware;

    public function test_generate_bank_slip(): void
    {
        $data = [
            'person_name' => fake()->name(),
            'person_city' => fake()->city(),
            'person_uf' => 'PR',
            'person_document' => '12345678901',
            'person_address' => 'Rua das Flores 123',
            'person_zipcode' => fake()->numerify('########'),
            'bill_amount' => fake()->randomFloat(2, 10, 1000),
            'bill_due_date' => date("Y-m-d", strtotime("+7 days")),
            'bank' => fake()->randomElement(['itau', 'bb', 'santander', 'bradesco']),
        ];
        $response = $this->post('/api/bank-slip/create', $data, [
            'Authorization' => 'Bearer test-token',
        ]);

        $jsonContent = json_decode($response->getContent(), true);
        $this->assertEquals(true, is_bool($jsonContent['success']), $response->getContent());
    }

    public function test_print_bank_slip(): void
    {
        $response = $this->get('/api/bank-slip/print/1');
        $content = $response->getContent();
        $this->assertEquals(true, !empty($content));
    }
}
