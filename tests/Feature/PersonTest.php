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
            'person_document' => "83274934003",
            'person_city' => fake()->city(),
            'person_state' => fake()->randomElement(['SP', 'RJ', 'MG', 'ES', 'PR']),
        ];
        $response = $this->post('/api/person', $data);

        $this->assertEquals(true, in_array($response->getStatusCode(), [200, 201, 202]), $response->getContent());
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
        $jsonContent = $response->json();

        $this->assertEquals(true, $jsonContent['code'] === 422, 'Http code invalid');
    }
}
