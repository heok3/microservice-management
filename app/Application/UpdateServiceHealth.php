<?php

namespace Application;

use Domain\CacheRepository;
use Domain\MicroserviceNotFoundException;

class UpdateServiceHealth
{
    public function __construct(private CacheRepository $cacheRepository)
    {
    }

    /**
     * @param string $url
     * @param int $healthMs
     *
     * @return void
     *
     * @throws MicroserviceNotFoundException
     */
    public function execute(string $url, int $healthMs): void
    {
        $microservices = $this->cacheRepository->getServiceList();
        $microservice = $microservices->searchByUrl($url);
        $microservice->setHealthMs($healthMs);
        $this->cacheRepository->update($microservices);
    }
}
