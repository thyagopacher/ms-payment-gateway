<?php

namespace Tests\Unit\Dto;

use App\Dto\PaymentoDTO;

class PaymentDtoTest extends \Tests\TestCase
{
    public function test_from_array(): void
    {
        $data = [
            'id' => '123',
            'status' => 'paid',
            'amount' => 1000,
            'payment_method' => 'pix',
            'person_document' => '28612460069',
            'bill_due_date' => '2024-12-31',
            'bill_paid_at' => '2024-12-01'
        ];

        $paymentDto = PaymentoDTO::fromArray($data);

        $this->assertEquals('123', $paymentDto->id);
        $this->assertEquals('paid', $paymentDto->status->value);
        $this->assertEquals(1000, $paymentDto->amount->getValue());
        $this->assertEquals('pix', $paymentDto->payment_method->value);
        $this->assertEquals('28612460069', $paymentDto->document->getValue());
        $this->assertEquals('2024-12-31', $paymentDto->dueDate);
        $this->assertEquals('2024-12-01', $paymentDto->paidAt);
    }

    public function test_to_array(): void
    {
        $paymentDto = new PaymentoDTO(
            id: '123',
            status: \App\Enums\PaymentStatus::PAID,
            amount: new \App\ValueObject\Money(1000),
            payment_method: \App\Enums\PaymentMethod::PIX,
            document: new \App\ValueObject\Document('28612460069'),
            dueDate: '2024-12-31',
            paidAt: '2024-12-01'
        );

        $array = $paymentDto->toArray();

        $this->assertEquals('123', $array['id']);
        $this->assertEquals('paid', $array['status']);
        $this->assertEquals(1000, $array['amount']);
        $this->assertEquals('pix', $array['payment_method']);
        $this->assertEquals('28612460069', $array['document']);
        $this->assertEquals('2024-12-31', $array['due_date']);
        $this->assertEquals('2024-12-01', $array['paid_at']);
    }
}
