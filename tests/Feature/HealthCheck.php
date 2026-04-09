<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthCheck extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_health_check(): void
    {
        $response = $this->get('/api/health-check');
        $response->assertStatus(200);
    }
}
