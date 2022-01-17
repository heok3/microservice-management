<?php

namespace Application;

use Domain\CacheRepository;
use Domain\Microservices;

class ListMicroservice
{
    public function __construct(private CacheRepository $cacheRepository)
    {}

    public function execute(): Microservices
    {
        return $this->cacheRepository->getServiceList();
    }
}
