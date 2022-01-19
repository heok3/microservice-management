<?php

namespace Application;

use Exception;
use Throwable;

class MicroserviceUrlAlreadyRegisteredException extends Exception
{
    private const ERROR_MESSAGE = 'Microservice Url Already Registered';

    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(self::ERROR_MESSAGE, previous: $previous);
    }
}
