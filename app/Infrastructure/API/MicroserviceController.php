<?php

namespace Infrastructure\API;

use Application\ListMicroservice;

class MicroserviceController
{
    public function index(ListMicroservice $listMicroservice): ListMicroserviceView
    {
        return new ListMicroserviceView($listMicroservice->execute());
    }
}
