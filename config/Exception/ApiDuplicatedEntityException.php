<?php

namespace Configuration\Exception;

class ApiDuplicatedEntityException extends ApiBaseException
{
    protected int $statusCode = 422;
}
