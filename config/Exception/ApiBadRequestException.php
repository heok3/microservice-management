<?php

namespace Configuration\Exception;

class ApiBadRequestException extends ApiBaseException
{
    protected int $statusCode = 400;
}
