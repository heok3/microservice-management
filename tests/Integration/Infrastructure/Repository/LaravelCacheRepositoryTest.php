<?php

namespace Test\Integration\Infrastructure\Repository;

use Domain\GlobalValues;
use Domain\Microservice;
use Illuminate\Support\Facades\Cache;
use Infrastructure\Repository\LaravelCacheRepository;
use Test\TestCase;

final class LaravelCacheRepositoryTest extends TestCase
{
    /** @test */
    public function it_can_return_empty_list(): void
    {
        $repo = new LaravelCacheRepository();
        $list = $repo->getServiceList();
        self::assertEmpty($list);
    }

    /** @test */
    public function it_can_return_list(): void
    {
        $service = [
            'id' => 'server_id',
            'url' => 'http://localhost:8080',
        ];

        Cache::add(GlobalValues::SERVICE_LIST_KEY, [$service]);
        $repo = new LaravelCacheRepository();
        $list = $repo->getServiceList();
        self::assertCount(1, $list);
        /** @var Microservice $microservice */
        $microservice = $list[0];
        self::assertEquals($service['id'], $microservice->getId());
        self::assertEquals($service['url'], $microservice->getUrl());
    }

    /** @test */
    public function it_can_register_first_microservice(): void
    {
        $microservice = new Microservice(
            id: 'service_id',
            url: 'http://localhost:8080',
        );

        $repo = new LaravelCacheRepository();
        $result = Cache::get(GlobalValues::SERVICE_LIST_KEY);
        self::assertEmpty($result);
        $repo->saveMicroservice($microservice);
        $result = Cache::get(GlobalValues::SERVICE_LIST_KEY);
        self::assertCount(1, $result);
        self::assertContains($microservice->toArray(), $result);
    }

    /** @test */
    public function it_can_register_a_microservice(): void
    {
        $firstService = new Microservice(
            id: 'first_service',
            url: 'http://localhost:8080',
        );

        $secondService = new Microservice(
            id: 'second_service',
            url: 'http://localhost:8000',
        );

        Cache::put(GlobalValues::SERVICE_LIST_KEY, [$firstService->toArray()]);
        $repo = new LaravelCacheRepository();
        $repo->saveMicroservice($secondService);
        $result = Cache::get(GlobalValues::SERVICE_LIST_KEY);
        self::assertCount(2, $result);
        self::assertContains($firstService->toArray(), $result);
        self::assertContains($secondService->toArray(), $result);
    }
}
