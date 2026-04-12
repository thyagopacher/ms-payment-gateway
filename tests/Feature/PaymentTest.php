<?php

namespace Tests\Feature;

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

    public function test_get_payments_return_httpcode(): array
    {
        $response = $this->get('/api/payments?limit=3');
        $response->assertStatus(200);

        $jsonContent = $response->json();
        return $jsonContent;
    }

    #[Depends("test_get_payments_return_httpcode")]
    public function test_get_payments_valid_content(array $content): void
    {
        $this->assertEquals(true, $content['success'] === true, 'Response success field is not true');
        $this->assertEquals(true, is_numeric($content['count']) && $content['count'] >= 0, 'Response count field is not a valid number');
        $this->assertEquals(true, is_array($content['payments']), 'Response payments field is not an array');
        $this->assertEquals(true, $content['count'] === count($content['payments']), 'Response payments field does not match count');
    }
}
