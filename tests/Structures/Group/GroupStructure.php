<?php

namespace Tests\Structures\Group;

use App\Http\Resources\Group\GroupResource;
use Tests\Structures\Structure;

final class GroupStructure extends Structure
{
    public function getStructure(): array
    {
        return [
            GroupResource::KEY_ID,
            GroupResource::KEY_NAME,
            GroupResource::KEY_CODE,
        ];
    }
}
