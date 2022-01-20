<?php

namespace Test\Unit\Domain;

use Domain\Microservice;
use Domain\Microservices;
use Domain\MicroserviceNotFoundException;
use PHPUnit\Framework\TestCase;

final class MicroservicesTest extends TestCase
{
    /** @test */
    public function it_can_be_created_if_the_array_has_only_microservice_instance(): void
    {
        $microservice = self::createMock(Microservice::class);
        $microservices = Microservices::fromArray([$microservice]);
        self::assertInstanceOf(Microservices::class, $microservices);
    }

    /** @test */
    public function it_cannot_be_created_if_the_array_has_non_microservice_instance(): void
    {
        $microservice = self::createMock(Microservice::class);
        self::expectError();
        Microservices::fromArray([$microservice, 'hello']);
    }

    /** @test */
    public function it_can_be_created_with_empty_array(): void
    {
        $microservices = Microservices::fromArray([]);
        self::assertInstanceOf(Microservices::class, $microservices);
    }

    /** @test */
    public function it_can_check_if_there_is_a_microservice_with_given_url(): void
    {
        $microserviceA = new Microservice(
            id: 'service_a',
            url: '123.123.123.123',
            healthMs: 0,
        );

        $microserviceB = new Microservice(
            id: 'service_b',
            url: '222.222.222.222',
            healthMs: 0,
        );

        $anyUrl = '111.111.111.111';
        $microservices = Microservices::fromArray([$microserviceA, $microserviceB]);
        self::assertTrue($microservices->hasUrl($microserviceB->getUrl()));
        self::assertFalse($microservices->hasUrl($anyUrl));
    }

    /** @test */
    public function it_can_search_by_url(): void
    {
        $microserviceA = new Microservice(
            id: 'service_a',
            url: '123.123.123.123',
            healthMs: 0,
        );

        $microserviceB = new Microservice(
            id: 'service_b',
            url: '222.222.222.222',
            healthMs: 0,
        );

        $anyUrl = '111.111.111.111';
        $microservices = Microservices::fromArray([$microserviceA, $microserviceB]);
        $microservice = $microservices->searchByUrl($microserviceB->getUrl());
        self::assertEquals($microserviceB->getUrl(), $microservice->getUrl());
        self::expectException(MicroserviceNotFoundException::class);
        self::assertNull($microservices->searchByUrl($anyUrl));
    }
}
