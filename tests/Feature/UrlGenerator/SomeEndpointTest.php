<?php

declare(strict_types=1);

namespace Tests\Feature\UrlGenerator;

use App\Http\Actions\Some\SomeAction;
use Illuminate\Http\Resources\Json\JsonResource;
use Tests\TestCase;

final class SomeEndpointTest extends TestCase
{
    public function testSomeEndpointSuccessResponse(): void
    {
        $url = $this->urlGenerator->action(SomeAction::class);
        $urlByName = $this->urlGenerator->route('some-endpoint');

        $this->assertEquals($url, $urlByName);

        $response = $this->getJson($url);

        $response->assertOk();
        $response->assertExactJson([
            JsonResource::$wrap => [
                'some data',
            ],
        ]);
    }
}
