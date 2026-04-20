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
            'person_name' => 'João da Silva',
            'person_city' => 'Curitiba',
            'person_uf' => 'PR',
            'person_cpf_cnpj' => '12345678901',
            'person_address' => 'Rua das Flores 123',
            'person_zipcode' => '80000000',
            'bill_amount' => 150.75,
            'bill_due_date' => '2026-04-20',
            'bank' => 'itau'
        ];
        $response = $this->post('/api/bank-slip/create', $data, [
            'Authorization' => 'Bearer test-token',
        ]);

        $jsonContent = json_decode($response->getContent(), true);
        $this->assertEquals(true, $jsonContent['success'], $response->getContent());
    }

    public function test_print_bank_slip(): void
    {
        $response = $this->get('/api/bank-slip/print/1');
        $content = $response->getContent();
        $this->assertEquals(true, !empty($content));
    }
}
