<?php

declare(strict_types=1);

namespace Tests\Feature\UrlGenerator;

use App\Http\Actions\UrlParameters\UrlParametersAction;
use Illuminate\Http\Resources\Json\JsonResource;
use Tests\TestCase;

final class UrlGeneratorTest extends TestCase
{
    public function testSomeEndpointSuccessResponse(): void
    {
        $number = $this->faker->randomNumber(3);

        $urlByAction = $this->urlGenerator->action(UrlParametersAction::class, [
            'id' => $number
        ]);

        $urlByName = $this->urlGenerator->route('url-parameters', [
            'id' => $number
        ]);

        $this->assertEquals($urlByAction, $urlByName);

        $this->getJson($urlByAction)
            ->assertOk()
            ->assertExactJson([
                JsonResource::$wrap => [
                    $number
                ],
            ])
        ;
    }
}
