<?php

namespace Domain;

interface CacheRepository
{
    public function getServiceList(): Microservices;
}
