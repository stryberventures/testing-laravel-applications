<?php

namespace Tests\Feature\Auth;

use Tests\Feature\Traits\WithAuthentication;
use Tests\TestCase;

final class AuthTest extends TestCase
{
    use WithAuthentication;

    public function testSeeUserInfo(): void
    {
        $this->authAsUser();

        $this->getJson($this->urlGenerator->route('user-info'))->assertOk();
    }

    public function testSeeUserInfoUnUnauthorized(): void
    {
        $this->authAsUser();
        $this->logout();

        $this->getJson($this->urlGenerator->route('user-info'))->assertUnauthorized();
    }
}
