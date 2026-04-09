<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankSlipTest extends TestCase
{

    public function test_generate_bank_slip(): void
    {
        $data = [
            'amount' => 100.50,
            'due_date' => '2024-12-31',
            'payer' => [
                'name' => 'John Doe',
                'cpf' => '12345678900',
                'email' => 'john.doe@example.com'
            ]
        ];
        $response = $this->post('/bank-slip/create', $data);

        $response->assertStatus(200);
    }

    public function test_print_bank_slip(): void
    {
        $response = $this->get('/bank-slip/print');
        $response->assertStatus(200);
    }
}
