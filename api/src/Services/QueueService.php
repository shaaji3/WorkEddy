<?php

declare(strict_types=1);

namespace WorkEddy\Api\Services;

use RuntimeException;

final class QueueService
{
    private object $client;

    public function __construct(private string $queueName = 'scan_jobs')
    {
        if (!class_exists(\Predis\Client::class)) {
            throw new RuntimeException('Predis is required for queue operations. Run composer install in api/.');
        }

        $host = getenv('REDIS_HOST') ?: '127.0.0.1';
        $port = (int) (getenv('REDIS_PORT') ?: '6379');
        $this->client = new \Predis\Client(['scheme' => 'tcp', 'host' => $host, 'port' => $port]);
    }

    public function enqueueScanJob(array $payload): void
    {
        $this->client->lpush($this->queueName, json_encode($payload, JSON_THROW_ON_ERROR));
    }
}
