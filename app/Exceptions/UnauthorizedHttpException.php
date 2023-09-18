<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedHttpException extends Exception
{
    public function render(): JsonResponse
    {
        return new JsonResponse(['message' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
    }
}
