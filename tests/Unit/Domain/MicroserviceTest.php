<?php

namespace Test\Unit\Domain;

use Carbon\Carbon;
use Domain\Microservice;
use PHPUnit\Framework\TestCase;

final class MicroserviceTest extends TestCase
{
    /** @test */
    public function it_can_return_data_to_array(): void
    {
        $microservice = new Microservice(
            id: 'service_id',
            url: 'http://localhost:8080',
            healthMs: 0,
            updatedAt: Carbon::now(),
            createdAt: Carbon::now(),
        );

        $result = $microservice->toArray();
        self::assertEquals($microservice->getId(), $result['id']);
        self::assertEquals($microservice->getUrl(), $result['url']);
        self::assertEquals($microservice->getHealthMs(), $result['health_ms']);
    }
}
