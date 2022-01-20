<?php

namespace Infrastructure\API;

use Domain\Microservice;
use Domain\Microservices;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ListMicroserviceView implements Responsable
{
    public function __construct(private Microservices $microservices)
    {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->build());
    }

    private function build(): array
    {
        return $this->microservices->map(
            fn(Microservice $microservice) => [
                'id' => $microservice->getId(),
                'url' => $microservice->getUrl(),
                'health-ms' => $microservice->getHealthMs(),
            ]
        )
            ->toArray();
    }
}
