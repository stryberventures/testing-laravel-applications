<?php

declare(strict_types=1);

namespace Tests\Feature\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait WithAuthentication
{
    final protected function authAsUser(?User $user = null): User
    {
        if (empty($user)) {
            $user = User::factory()->create();
        }

        $this->actingAs($user, 'sanctum');

        return $user;
    }

    protected function logout(): void
    {
        /** @uses \Tests\TestCase::setUp() */
        Auth::guard('sanctum')->logout();
    }
}
