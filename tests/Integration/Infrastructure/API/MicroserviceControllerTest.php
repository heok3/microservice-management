<?php

namespace Test\Integration\Infrastructure\API;

use Application\RegisterMicroservice;
use Domain\GlobalValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Infrastructure\API\MicroserviceController;
use Infrastructure\Repository\LaravelCacheRepository;
use Test\TestCase;

final class MicroserviceControllerTest extends TestCase
{
    private const CLIENT_ADDR = '10.1.0.1';
    private const CACHE_KEY_NAME = GlobalValues::SERVICE_LIST_KEY;

    /** @test */
    public function it_must_register_a_first_microservice_with_client_ip(): void
    {
        $serviceId = 'service_id';
        $controller = new Microservicecontroller();
        $data = [
            'id' => $serviceId,
        ];

        $request = Request::create(
            uri: '/api/microservice',
            method: 'POST',
            parameters: $data,
            server: ['REMOTE_ADDR' => self::CLIENT_ADDR],
        );

        $expectedValue = [
            'id' => $serviceId,
            'url' => self::CLIENT_ADDR,
        ];

        $response = $controller->store($request, new RegisterMicroservice(new LaravelCacheRepository()));
        self::assertEquals(204, $response->getStatusCode());
        $cache = Cache::get(self::CACHE_KEY_NAME);
        self::assertCount(1, $cache);
        self::assertContains($expectedValue, $cache);
    }

    /** @test */
    public function it_must_register_a_microservice_with_client_ip(): void
    {
        $firstService = [
            'id' => 'first_service',
            'url' => '111.111.111.111',
        ];

        Cache::put(self::CACHE_KEY_NAME, [$firstService]);
        $serviceId = 'service_id';
        $controller = new Microservicecontroller();
        $data = [
            'id' => $serviceId,
        ];

        $request = Request::create(
            uri: '/api/microservice',
            method: 'POST',
            parameters: $data,
            server: ['REMOTE_ADDR' => self::CLIENT_ADDR],
        );

        $expectedValue = [
            'id' => $serviceId,
            'url' => self::CLIENT_ADDR,
        ];

        $response = $controller->store($request, new RegisterMicroservice(new LaravelCacheRepository()));
        self::assertEquals(204, $response->getStatusCode());
        $cache = Cache::get(self::CACHE_KEY_NAME);
        self::assertCount(2, $cache);
        self::assertContains($firstService, $cache);
        self::assertContains($expectedValue, $cache);
    }
}
