<?php

namespace Domain;

use Illuminate\Support\Collection;

class Microservices extends Collection
{
    public static function fromArray(array $microservices) {
        array_map(fn(Microservice $microservice) => 'hello', $microservices);
        return new Microservices($microservices);
    }

    public function hasUrl(string $url): bool
    {
        $result = $this->first(fn(Microservice $microservice) => $microservice->getUrl() === $url);

        return !is_null($result);
    }

    public function hasId(string $id): bool
    {
        $result = $this->first(fn(Microservice $microservice) => $microservice->getId() === $id);

        return !is_null($result);
    }
}
