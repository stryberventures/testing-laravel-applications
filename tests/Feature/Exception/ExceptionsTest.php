<?php

declare(strict_types=1);

namespace Tests\Feature\Exception;

use App\Exceptions\SomeException;
use App\Http\Resources\ApiExceptionResource;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class ExceptionsTest extends TestCase
{
    public function testExceptionIsThrown(): void
    {
        $url = $this->urlGenerator->route('make-exception');

        $response = $this->getJson($url);

        // Exceptions that doesn't inherit from App\Exceptions\ApiException\ApiException::class
        // $this->assertStringContainsString(
        //     __('exceptions.group.message'),
        //     $response->json('message')
        // );

        // Exceptions that inherit from App\Exceptions\ApiException\ApiException::class
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn(AssertableJson $json) =>
                $json->has(
                    'error',
                    fn(AssertableJson $json) => $json
                        ->where(
                            ApiExceptionResource::KEY_CODE,
                            SomeException::CODE
                        )
                        ->where(ApiExceptionResource::KEY_FALLBACK_MESSAGE, __('exceptions.group.message'))
                        ->where(ApiExceptionResource::KEY_PAYLOAD, [])
                        ->etc()
                )
            )
        ;
    }
}
