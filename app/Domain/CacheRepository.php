<?php

namespace Domain;

interface CacheRepository
{
    public function getServiceList(): Microservices;
    public function saveMicroservice(Microservice $microservice): void;
}
