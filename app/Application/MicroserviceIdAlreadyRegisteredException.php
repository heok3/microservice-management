<?php

namespace Application;

use Exception;
use Throwable;

class MicroserviceIdAlreadyRegisteredException extends Exception
{
    private const ERROR_MESSAGE = 'Microservice id Already Registered';

    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(self::ERROR_MESSAGE, previous: $previous);
    }
}
