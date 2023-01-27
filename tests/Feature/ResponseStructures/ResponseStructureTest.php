<?php

declare(strict_types=1);

namespace Tests\Feature\ResponseStructures;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Tests\Feature\Traits\WithAuthentication;
use Tests\Structures\User\UserStructure;
use Tests\Structures\User\UserWithGroupStructure;
use Tests\TestCase;

final class ResponseStructureTest extends TestCase
{
    use WithAuthentication;

    public function testResponseStructure(): void
    {
        $user = User::factory()->create();
        $this->authAsUser($user);

        $groupShouldBeInResponse = $this->faker->boolean();
        $response = $this->getJson($this->urlGenerator->route('user-info', [
            'with_group' => $groupShouldBeInResponse
        ]));
        $response->assertOk();

        $structure = $groupShouldBeInResponse
            ? new UserWithGroupStructure()
            : new UserStructure()
        ;

        $response->assertJsonStructure([
            /** @see Structure::getCollectionStructure() for collections **/
            JsonResource::$wrap => $structure->getStructure()
        ]);
    }
}
