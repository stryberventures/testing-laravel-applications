<?php

namespace Tests;

use Illuminate\Auth\RequestGuard;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use WithFaker;
    // use RefreshDatabase;

    protected UrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->urlGenerator = $this->app->make(UrlGenerator::class);

        // To be able to make user unauthorized
        RequestGuard::macro('logout', function () {
            $this->user = null;
        });
    }

    final public function debug($data): void
    {
        fwrite(STDERR, var_export($data, true) . "\n");
    }

    final public function getJsonContentFromFile(string $path): array
    {
        return json_decode(file_get_contents(base_path() . '/' . $path), true);
    }
}
