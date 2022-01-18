<?php

namespace Application;

use Domain\CacheRepository;
use Domain\Microservice;

class RegisterMicroservice
{
    public function __construct(private CacheRepository $cacheRepository)
    {
    }

    /**
     * @throws MicroserviceIdAlreadyRegisteredException
     * @throws MicroserviceUrlAlreadyRegisteredException
     */
    public function execute(Microservice $microservice): void
    {
        $list = $this->cacheRepository->getServiceList();
        if($list->hasId($microservice->getId())) {
            throw new MicroserviceIdAlreadyRegisteredException($microservice->getId());
        }

        if($list->hasUrl($microservice->getUrl())) {
            throw new MicroserviceUrlAlreadyRegisteredException($microservice->getUrl());
        }

        $this->cacheRepository->saveMicroservice($microservice);
    }
}
