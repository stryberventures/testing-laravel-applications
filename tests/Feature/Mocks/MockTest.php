<?php

declare(strict_types=1);

namespace Tests\Feature\Mocks;

use App\Http\Actions\ActionWithHttpRequest\HttpRequestAction;
use App\Infrastructure\Repositories\ElasticSearch\ElasticsearchRepositoryInterface;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\MockInterface;
use Tests\TestCase;
use GuzzleHttp\Psr7\Response;

final class MockTest extends TestCase
{
    public function testMakingHttpRequestSuccess()
    {
        $url = $this->urlGenerator->action(HttpRequestAction::class);

        $mockedData = '[{"status":{"verified":true,"sentCount":1},"_id":"58e008800aac31001185ed07","user":"58e007480aac31001185ecef","text":"Wikipedia has a recording of a cat meowing, because why not?","__v":0,"source":"user","updatedAt":"2020-08-23T20:20:01.611Z","type":"cat","createdAt":"2018-03-06T21:20:03.505Z","deleted":false,"used":false}]';

        /**
         * Also @see TestCase::partialMock
         * You may use the partialMock method when you only need to mock a few methods of an object.
         * The methods that are not mocked will be executed normally
         *
         * Also @see TestCase::createPartialMock
         * Also @see Mockery::mock
         * Also @see MockInterface::makePartial
         */
        $this->mock(ClientInterface::class, function (MockInterface $mock) use ($mockedData) {
            $mock
                ->shouldReceive('request')
                ->with(HttpRequestAction::API_HTTP_METHOD, HttpRequestAction::API_URL)
                ->once()
                ->andReturn(
                    new Response(
                        $status = 200,
                        $headers = [],
                        $mockedData
                    )
                )
            ;
        });

        $this->getJson($url)
            ->assertOk()
            ->assertJson([
                JsonResource::$wrap => [
                    json_decode($mockedData, true)[0]
                ],
            ])
        ;
    }
}
