<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Http\Response;

final class SomeException extends DomainException implements ApiException
{
    public const CODE = 'exception.code.for.frontend';

    public function getExceptionCode(): string
    {
        return self::CODE;
    }

    public function getFallbackMessage(): string
    {
        return __('exceptions.group.message');
    }

    public function getPayload(): array
    {
        return [];
    }

    public function getHttpCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }
}
