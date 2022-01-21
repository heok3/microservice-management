<?php

namespace Test\Feature\Infrastructure\API;

use Carbon\Carbon;
use Domain\GlobalValues;
use Illuminate\Support\Facades\Cache;
use Test\TestCase;

final class ReceiveHealthControllerTest extends TestCase
{
    private const SERVICE_LIST_KEY = GlobalValues::SERVICE_LIST_KEY;
    private Carbon $now;

    public function setUp(): void
    {
        parent::setUp();
        $this->now = Carbon::now();
        Carbon::setTestNow($this->now);
    }

    /** @test */
    public function client_can_update_its_health(): void
    {
        $serviceId = 'service_id';
        $cache = [
            'id' => $serviceId,
            'url' => '127.0.0.1',
            'health_ms' => 0,
            'updated_at' => $this->now->timestamp,
            'created_at' => $this->now->timestamp,
        ];

        Cache::put(self::SERVICE_LIST_KEY, [$cache]);

        $healthMs = 1234;
        $data = [
            'id' => $serviceId,
            'health_ms' => $healthMs,
        ];

        $response = $this->json('GET', $this->getUrl(), $data);
        $response->assertResponseStatus(204);
        $serviceList = Cache::get(self::SERVICE_LIST_KEY);
        self::assertEquals($healthMs, $serviceList[0]['health_ms']);
    }

    /** @test */
    public function client_cannot_update_another(): void
    {
        $serviceId = 'service_id';
        $cache = [
            'id' => $serviceId,
            'url' => '127.127.127.1',
            'health_ms' => 0,
            'updated_at' => $this->now->timestamp,
            'created_at' => $this->now->timestamp,
        ];

        Cache::put(self::SERVICE_LIST_KEY, [$cache]);

        $healthMs = 1234;
        $data = [
            'id' => $serviceId,
            'health_ms' => $healthMs,
        ];

        $response = $this->json('GET', $this->getUrl(), $data);
        $response->assertResponseStatus(400);
        $serviceList = Cache::get(self::SERVICE_LIST_KEY);
        self::assertEquals(0, $serviceList[0]['health_ms']);
    }

    private function getUrl(): string
    {
        return '/api/microservices/health';
    }
}
