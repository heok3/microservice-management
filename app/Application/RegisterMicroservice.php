<?php

namespace Application;

use Domain\CacheRepository;
use Domain\Microservice;

class RegisterMicroservice
{
    public function __construct(private CacheRepository $cacheRepository)
    {
    }

    public function execute(Microservice $microservice): void
    {
        $this->cacheRepository->saveMicroservice($microservice);
    }
}
