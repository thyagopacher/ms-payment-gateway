<?php

namespace Tests\Feature;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;

class PaymentTest extends TestCase
{

    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_creat_payment(): void
    {
        $paymentDate = date("Y-m-d H:i:s");
        $data = [
            'bill_amount' => fake()->randomFloat(2, 10, 1000),
            'status' => PaymentStatus::PENDING->value,
            'payment_method' => PaymentMethod::BANK_SLIP->value,
            'bill_paid_at' => $paymentDate,
            'bill_due_date' => date($paymentDate, strtotime("+7 days")),
            'person_document' => '05820810929',
        ];
        $response = $this->post('/api/payment', $data);
        $jsonContent = $response->json();

        $this->assertEquals(true, is_bool($jsonContent['success']), json_encode($jsonContent));
    }

    public function test_get_payments_return_httpcode(): array
    {
        $response = $this->get('/api/payment?limit=3');
        $response->assertStatus(200);

        $jsonContent = $response->json();
        return $jsonContent;
    }

     
}
