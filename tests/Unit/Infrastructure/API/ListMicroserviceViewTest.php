<?php

namespace Test\Unit\Infrastructure\API;

use Carbon\Carbon;
use Domain\Microservice;
use Domain\Microservices;
use Illuminate\Http\Request;
use Infrastructure\API\ListMicroserviceView;
use PHPUnit\Framework\TestCase;

final class ListMicroserviceViewTest extends TestCase
{
    /** @test */
    public function it_can_return_json_response(): void
    {
        $microservice = new Microservice(
            id: 'service_id',
            url: 'http://localhost:8080',
            healthMs: 0,
            updatedAt: Carbon::now(),
            createdAt: Carbon::now(),
        );

        $view = new ListMicroserviceView(new Microservices([$microservice]));
        $request = self::createMock(Request::class);
        $response = $view->toResponse($request);
        $content = json_decode($response->content(), JSON_OBJECT_AS_ARRAY);
        self::assertCount(1, $content);
        self::assertEquals($microservice->getId(), $content[0]['id']);
        self::assertEquals($microservice->getUrl(), $content[0]['url']);
    }
}
