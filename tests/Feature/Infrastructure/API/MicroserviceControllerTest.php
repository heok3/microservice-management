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

        Cache::add(GlobalValues::SERVICE_LIST_KEY, [$service]);
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

    private function getUrl(): string
    {
        return '/api/microservices';
    }
}
