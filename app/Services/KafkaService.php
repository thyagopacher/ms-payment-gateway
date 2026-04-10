<?php

namespace App\Services;

use Junges\Kafka\Facades\Kafka;

class KafkaService
{

    public function __construct()
    {

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
