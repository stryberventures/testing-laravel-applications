<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Group\GroupResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
final class UserWithGroupResource extends JsonResource
{
    public const KEY_FIRSTNAME = User::COLUMN_FIRSTNAME;
    public const KEY_LASTNAME = User::COLUMN_LASTNAME;
    public const KEY_USERNAME = User::COLUMN_USERNAME;
    public const KEY_EMAIL = User::COLUMN_EMAIL;
    public const KEY_IMAGE = User::COLUMN_IMAGE;
    public const KEY_GROUP = User::RELATION_GROUP;

    public function toArray($request): array
    {
        return [
            self::KEY_FIRSTNAME => $this->firstname,
            self::KEY_LASTNAME => $this->lastname,
            self::KEY_USERNAME => $this->username,
            self::KEY_EMAIL => $this->email,
            self::KEY_IMAGE => $this->image,
            self::KEY_GROUP => new GroupResource($this->group),
        ];
    }
}
