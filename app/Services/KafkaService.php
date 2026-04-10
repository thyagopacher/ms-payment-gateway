<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;

class KafkaService
{

    public function __construct()
    {

    }

    public function healthCheck(): bool
    {
        try {
            $res = Kafka::publish()
                ->onTopic('health-check')
                ->withBodyKey('ping', now()->timestamp)
                ->send();
            return $res;
        } catch (\Exception $e) {
            Log::error('Kafka health check failed: ' . $e->getMessage());
            return false;
        }
    }

    public function publish(string $topic, array $data): bool
    {
        $producer = Kafka::publish()
            ->onTopic($topic)
            ->withBody($data);

        return $producer->send();
    }

    public function startConsumer(string $topic, callable $handler): bool
    {
        $consumer = Kafka::consumer([$topic])
            ->withHandler($handler)
            ->build();

        $consumer->consume();

        return true;
    }

}
