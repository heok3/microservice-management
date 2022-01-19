<?php

namespace Configuration\Exception;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class ApiBaseException extends Exception
{
    protected int $statusCode = 404;

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => static::getMessage(),
        ], $this->statusCode);
    }
}
