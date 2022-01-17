<?php

namespace Domain;

use Illuminate\Support\Collection;

class Microservices extends Collection
{
    public static function fromArray(array $microservices) {
        array_map(fn(Microservice $microservice) => 'hello', $microservices);
        return new Microservices($microservices);
    }
}
