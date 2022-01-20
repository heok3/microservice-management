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
        try {
            $this->searchByUrl($url);

            return true;
        } catch (MicroserviceNotFoundException) {
            return false;
        }
    }

    public function hasId(string $id): bool
    {
        $result = $this->first(fn(Microservice $microservice) => $microservice->getId() === $id);

        return !is_null($result);
    }

    /**
     * @param string $url
     *
     * @return Microservice
     *
     * @throws MicroserviceNotFoundException
     */
    public function searchByUrl(string $url): Microservice
    {
        $result = $this->first(
            fn(Microservice $microservice) =>
                $microservice->getUrl() === $url
        );

        if(is_null($result)) {
            throw new MicroserviceNotFoundException('There is no url:' . $url);
        }

        return $result;
    }
}
