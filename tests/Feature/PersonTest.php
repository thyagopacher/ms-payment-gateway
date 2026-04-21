<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PersonTest extends TestCase
{

    use WithoutMiddleware;

    public function test_create(): void
    {
        $data = [
            'person_name' => fake()->name(),
            'person_mail' => fake()->email(),
            'person_phone' => fake()->phoneNumber(),
            'person_document' => fake()->numerify('###########'),
        ];
        $response = $this->post('/api/person', $data);

        $response->assertStatus(200);
    }

    public function test_create_fail_attribute(): void
    {
        $data = [
            'person_name' => fake()->name(),
            'person_mail' => fake()->email(),
            'person_phone' => '41999998888',
            'document' => fake()->numerify('###########'),
        ];
        $response = $this->post('/api/person', $data);

        $response->assertStatus(422);
    }
}
