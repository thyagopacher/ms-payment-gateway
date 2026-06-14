<?php

namespace Tests\Feature;

use App\Services\Payment\StripeService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class StripeControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testCreateCharge(): void
    {
        $data = [
            'amount' => fake()->randomFloat(2, 0, 10000),
            'currency' => fake()->currencyCode(),
            'source' => '',
            'metadata' => [],
        ];
        $response = $this->post('/api/stripe/charges/create', $data, [
            'Authorization' => 'Bearer test-token',
        ]);

        $jsonContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('success', $jsonContent, 'Response does not contain success key: ' . $response->getContent());
        $this->assertEquals(true, is_bool($jsonContent['success']), 'Response does not contain a valid success value: ' . $response->getContent());

    }

    public function testCreateChargeWithoutAmount(): void
    {
        $data = [
            'currency' => fake()->currencyCode(),
            'source' => '',
            'metadata' => [],
        ];
        $response = $this->post('/api/stripe/charges/create', $data, [
            'Authorization' => 'Bearer test-token',
        ]);

        $jsonContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('success', $jsonContent, 'Response does not contain success key: ' . $response->getContent());
        $this->assertEquals(false, $jsonContent['success'], 'Response does not contain a valid success value: ' . $response->getContent());

    }

}
