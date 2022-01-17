<?php

namespace Test\Unit\Domain;

use Domain\Microservice;
use Domain\Microservices;
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
}
