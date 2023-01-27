<?php

namespace App\Http\Resources\Group;

use App\Models\Group;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Group */
final class GroupResource extends JsonResource
{
    public const KEY_ID = Group::COLUMN_ID;
    public const KEY_NAME = Group::COLUMN_NAME;
    public const KEY_CODE = Group::COLUMN_CODE;

    public function toArray($request): array
    {
        return [
            self::KEY_ID => $this->id,
            self::KEY_NAME => $this->name,
            self::KEY_CODE => $this->code,
        ];
    }
}
