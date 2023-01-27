<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithResourceResponse;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithGroupResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

final class ResourceAction extends Controller
{
    public function __invoke(Authenticatable $user, $withGroup = null): UserResource|UserWithGroupResource
    {
        assert($user instanceof User);

        return (bool)$withGroup ? new UserWithGroupResource($user) : new UserResource($user);
    }
}
