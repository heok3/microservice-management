<?php

namespace Infrastructure\API;

use Application\UpdateServiceHealth;
use Configuration\Exception\ApiBadRequestException;
use Domain\MicroserviceNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReceiveHealthController
{
    /**
     * @param Request $request
     * @param UpdateServiceHealth $updateServiceHealth
     *
     * @return Response
     *
     * @throws ApiBadRequestException
     */
    public function __invoke(Request $request, UpdateServiceHealth $updateServiceHealth): Response
    {
        try {
            $updateServiceHealth->execute(
                url: $request->getClientIp(),
                healthMs: $request->input('health_ms')
            );

            return new Response([], 204);
        } catch (MicroserviceNotFoundException $e) {
            throw new ApiBadRequestException($e->getMessage(), previous: $e);
        }
    }
}
