<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{

    public function test_health_check_access_route(): string
    {
        $response = $this->get('/api/health-check');
        $jsonContent = $response->getContent();

        $response->assertStatus(200);

        return $jsonContent;
    }

    #[Depends('test_health_check_access_route')]
    public function test_health_check_valid_json(string $jsonContent): void
    {
        $this->assertEquals(true, json_validate($jsonContent), 'Response content is not valid JSON');
    }

    #[Depends('test_health_check_access_route')]
    public function test_health_check_redis_ok(string $jsonContent): void
    {
        $json = json_decode($jsonContent, true);
        $this->assertEquals(true, $json['services']['redis'] === true, 'Redis service is not healthy');
    }

    #[Depends('test_health_check_access_route')]
    public function test_health_check_database_ok(string $jsonContent): void
    {
        $json = json_decode($jsonContent, true);
        $this->assertEquals(true, $json['services']['database'] === 'connected', 'Database service is not healthy');
    }

    #[Depends('test_health_check_access_route')]
    public function test_health_check_kafka_ok(string $jsonContent): void
    {
        $json = json_decode($jsonContent, true);
        $this->assertEquals(true, $json['services']['kafka'] === 'connected', 'Kafka service is not healthy');
    }

    #[Depends('test_health_check_access_route')]
    public function test_health_check_itau_ok(string $jsonContent): void
    {
        $json = json_decode($jsonContent, true);
        $this->assertEquals(true, $json['integrations']['banks']['itau'] === true, 'Itau service is not healthy');
    }
}
