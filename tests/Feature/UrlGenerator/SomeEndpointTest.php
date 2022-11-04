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
        $number = $this->faker->randomNumber(3);

        $urlByAction = $this->urlGenerator->action(SomeAction::class, [
            'id' => $number
        ]);

        $urlByName = $this->urlGenerator->route('some-endpoint', [
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
