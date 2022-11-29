<?php

declare(strict_types=1);

namespace Tests\Feature\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait WithAuthentication
{
    private function authAsUser(?User $user = null): User
    {
        if (empty($user)) {
            $user = User::factory()->create();
        }

        $this->actingAs($user, 'sanctum');

        return $user;
    }

    private function logout(): void
    {
        /** @uses \Tests\TestCase::setUp() */
        Auth::guard('sanctum')->logout();
    }
}
