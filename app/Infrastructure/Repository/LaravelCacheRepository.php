<?php

namespace Infrastructure\Repository;

use Domain\CacheRepository;
use Domain\GlobalValues;
use Domain\Microservice;
use Domain\Microservices;
use Illuminate\Support\Facades\Cache;

class LaravelCacheRepository implements CacheRepository
{
    private const SERVICE_LIST_KEY = GlobalValues::SERVICE_LIST_KEY;

    public function getServiceList(): Microservices
    {
        $serviceList = [];
        if(Cache::has(self::SERVICE_LIST_KEY)) {
            $serviceList = Cache::get(self::SERVICE_LIST_KEY);
        }

        return new Microservices(array_map(
            fn(array $microservice) => Microservice::fromCache($microservice),
            $serviceList,
        ));
    }

    public function saveMicroservice(Microservice $microservice): void
    {
        $serviceList = [];
        if(Cache::has(self::SERVICE_LIST_KEY)) {
            $serviceList = Cache::get(self::SERVICE_LIST_KEY);
        }

        $serviceList[] = $microservice->toArray();
        Cache::put(self::SERVICE_LIST_KEY, $serviceList);
    }
}
