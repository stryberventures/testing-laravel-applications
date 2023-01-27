<?php

declare(strict_types=1);

namespace Tests\Structures\User;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithGroupResource;
use Tests\Structures\Group\GroupStructure;
use Tests\Structures\Structure;

final class UserWithGroupStructure extends Structure
{
    public function getStructure(): array
    {
        return [
            UserResource::KEY_FIRSTNAME,
            UserResource::KEY_LASTNAME,
            UserResource::KEY_USERNAME,
            UserResource::KEY_EMAIL,
            UserResource::KEY_IMAGE,
            UserWithGroupResource::KEY_GROUP => (new GroupStructure())->getStructure()
        ];
    }
}
