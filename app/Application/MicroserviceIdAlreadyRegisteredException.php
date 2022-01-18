<?php

namespace Application;

use Exception;
use Throwable;

class MicroserviceIdAlreadyRegisteredException extends Exception
{
    private const ERROR_MESSAGE = 'Microservice id Already Registered';
    private string $id;

    public function __construct(string $id, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }

    public function getErrorArray(): array
    {
        return [
            'error' => 'id',
            'detail' => $this->id,
            'message' => self::ERROR_MESSAGE,
        ];
    }
}
