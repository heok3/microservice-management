<?php

namespace Infrastructure\API;

use Application\ListMicroservice;
use Application\MicroserviceIdAlreadyRegisteredException;
use Application\MicroserviceUrlAlreadyRegisteredException;
use Application\RegisterMicroservice;
use Configuration\Exception\ApiBadRequestException;
use Configuration\Exception\ApiDuplicatedEntityException;
use Domain\Microservice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MicroserviceController
{
    public function index(ListMicroservice $listMicroservice): ListMicroserviceView
    {
        return new ListMicroserviceView($listMicroservice->execute());
    }

    /**
     * @throws ApiBadRequestException
     * @throws ApiDuplicatedEntityException
     */
    public function store(Request $request, RegisterMicroservice $registerMicroservice): Response
    {
        try {
            if(is_null($request->getClientIp())){
                throw new ApiBadRequestException('Ip address is missing');
            }

            $registerMicroservice->execute(new Microservice(
                id: $request->input('id'),
                url: $request->getClientIp(),
            ));

            return new Response([], 204);
        } catch (
            MicroserviceIdAlreadyRegisteredException
            |MicroserviceUrlAlreadyRegisteredException $e) {
            throw new ApiDuplicatedEntityException(
                message: $e->getMessage(),
                previous: $e
            );
        }
    }
}
