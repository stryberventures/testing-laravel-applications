<?php

declare(strict_types=1);

namespace Tests\Structures\User;

use App\Http\Resources\User\UserResource;
use Tests\Structures\Structure;

final class UserStructure extends Structure
{
    public function getStructure(): array
    {
        return [
            UserResource::KEY_FIRSTNAME,
            UserResource::KEY_LASTNAME,
            UserResource::KEY_USERNAME,
            UserResource::KEY_EMAIL,
            UserResource::KEY_IMAGE,
        ];
    }
}
