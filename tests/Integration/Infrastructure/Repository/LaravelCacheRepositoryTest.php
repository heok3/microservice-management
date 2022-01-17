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
}
