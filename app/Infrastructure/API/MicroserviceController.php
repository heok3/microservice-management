<?php

namespace Infrastructure\API;

use Application\ListMicroservice;
use Application\RegisterMicroservice;
use Domain\Microservice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MicroserviceController
{
    public function index(ListMicroservice $listMicroservice): ListMicroserviceView
    {
        return new ListMicroserviceView($listMicroservice->execute());
    }

    public function store(Request $request, RegisterMicroservice $registerMicroservice): Response
    {
        $registerMicroservice->execute(new Microservice(
            id: $request->input('id'),
            url: $request->getClientIp(),
        ));

        return new Response([],204);
    }
}
