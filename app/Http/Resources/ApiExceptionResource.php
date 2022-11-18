<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Exceptions\ApiException;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ApiException */
final class ApiExceptionResource extends JsonResource
{
    public static $wrap = 'error';

    public const KEY_CODE = 'code';
    public const KEY_FALLBACK_MESSAGE = 'fallback_message';
    public const KEY_PAYLOAD = 'payload';

    public function toArray($request): array
    {
        return [
            self::KEY_CODE => $this->getExceptionCode(),
            self::KEY_FALLBACK_MESSAGE => $this->getFallbackMessage(),
            self::KEY_PAYLOAD => $this->getPayload(),
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->getHttpCode());
    }
}
