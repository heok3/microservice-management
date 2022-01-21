<?php

namespace Test\Integration\Infrastructure\Repository;

use Carbon\Carbon;
use Domain\GlobalValues;
use Domain\Microservice;
use Domain\Microservices;
use Illuminate\Support\Facades\Cache;
use Infrastructure\Repository\LaravelCacheRepository;
use Test\TestCase;

final class LaravelCacheRepositoryTest extends TestCase
{
    private Carbon $now;

    public function setUp(): void
    {
        parent::setUp();
        $this->now = Carbon::now();
        Carbon::setTestNow($this->now);
    }

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
            'url' => '111.111.111.1',
            'health_ms' => 0,
            'updated_at' => $this->now->timestamp,
            'created_at' => $this->now->timestamp,
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
            url: '111.111.111.1',
            healthMs: 0,
            updatedAt: $this->now,
            createdAt: $this->now,
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
            url: '111.111.111.1',
            healthMs: 0,
            updatedAt: $this->now,
            createdAt: $this->now,
        );

        $secondService = new Microservice(
            id: 'second_service',
            url: '111.111.111.2',
            healthMs: 0,
            updatedAt: $this->now,
            createdAt: $this->now,
        );

        Cache::put(GlobalValues::SERVICE_LIST_KEY, [$firstService->toArray()]);
        $repo = new LaravelCacheRepository();
        $repo->saveMicroservice($secondService);
        $result = Cache::get(GlobalValues::SERVICE_LIST_KEY);
        self::assertCount(2, $result);
        self::assertContains($firstService->toArray(), $result);
        self::assertContains($secondService->toArray(), $result);
    }

    /** @test */
    public function it_can_update_microservice_list(): void
    {
        $oldService = new Microservice(
            id: 'old_service',
            url: '111.111.111.111',
            healthMs: 0,
            updatedAt: $this->now,
            createdAt: $this->now,
        );

        $firstService = new Microservice(
            id: 'first_service',
            url: '111.111.111.1',
            healthMs: 0,
            updatedAt: $this->now,
            createdAt: $this->now,
        );

        $secondService = new Microservice(
            id: 'second_service',
            url: '111.111.111.2',
            healthMs: 0,
            updatedAt: $this->now,
            createdAt: $this->now,
        );

        Cache::put(GlobalValues::SERVICE_LIST_KEY, [$oldService->toArray()]);
        $repo = new LaravelCacheRepository();
        $repo->update(Microservices::fromArray([$firstService, $secondService]));
        $result = Cache::get(GlobalValues::SERVICE_LIST_KEY);
        self::assertCount(2, $result);
        self::assertContains($firstService->toArray(), $result);
        self::assertContains($secondService->toArray(), $result);
    }
}
