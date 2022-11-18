<?php

namespace App\Exceptions;

use Throwable;

interface ApiException extends Throwable
{
    public function getExceptionCode(): string;
    public function getFallbackMessage(): string;
    public function getPayload(): array;
    public function getHttpCode(): int;
}
