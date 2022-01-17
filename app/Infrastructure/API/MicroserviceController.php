<?php

namespace Infrastructure\API;

use Application\ListMicroservice;
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
        return new Response(204);
    }
}
