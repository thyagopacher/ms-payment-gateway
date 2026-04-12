<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PersonTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * A basic feature test example.
     */
    public function test_create(): void
    {
        $data = [
            'name' => fake()->name(),
            'mail' => fake()->email(),
            'phone' => '41999998888',
            'document' => fake()->numerify('###########'),
        ];
        $response = $this->post('/api/person', $data);

        $response->assertStatus(200);
    }
}
