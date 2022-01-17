<?php

namespace Test\Feature\Infrastructure\API;

use Domain\GlobalValues;
use Illuminate\Support\Facades\Cache;
use Test\TestCase;

final class MicroserviceControllerTest extends TestCase
{
    private const SERVICE_LIST_KEY = GlobalValues::SERVICE_LIST_KEY;

    /** @test */
    public function user_can_get_service_list(): void
    {
        $service = [
            'id' => 'serviceA',
            'url' => 'http://localhost:8080',
        ];

        Cache::add(self::SERVICE_LIST_KEY, [$service]);
        $response = self::get($this->getUrl());
        $response->assertResponseOk();
        $response->seeJsonEquals([$service]);
    }

    /** @test */
    public function user_must_get_empty_service_list_when_there_is_no_service_registered(): void
    {
        $response = self::get($this->getUrl());
        $response->assertResponseOk();
        $response->seeJsonEquals([]);
    }

    /** @test */
    public function client_can_register_as_a_microservice(): void
    {
        $data = [
            'id' => 'service_id',
            'url' => 'http://localhost:8080',
        ];

        $response = self::post($this->getUrl(), $data);
        $response->assertResponseOk();
        $result = Cache::get(self::SERVICE_LIST_KEY);
        self::assertCount(1, $result);
        self::assertContains($data, $result);
    }

    private function getUrl(): string
    {
        return '/api/microservices';
    }
}
