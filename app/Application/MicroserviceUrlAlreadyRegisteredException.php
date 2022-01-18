<?php

namespace Application;

use Exception;
use Throwable;

class MicroserviceUrlAlreadyRegisteredException extends Exception
{
    private const ERROR_MESSAGE = 'Microservice Url Already Registered';
    private string $url;

    public function __construct(string $url, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->url = $url;
    }

    public function getErrorArray(): array
    {
        return [
            'error' => 'url',
            'detail' => $this->url,
            'message' => self::ERROR_MESSAGE,
        ];
    }
}
