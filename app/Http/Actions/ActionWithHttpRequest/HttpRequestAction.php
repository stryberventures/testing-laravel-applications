<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithHttpRequest;

use App\Http\Controllers\Controller;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Resources\Json\JsonResource;
use Psr\Log\LoggerInterface;

final class HttpRequestAction extends Controller
{
    public const API_URL = 'https://cat-fact.herokuapp.com/facts';
    public const API_HTTP_METHOD = 'GET';

    public function __construct(
        private ClientInterface $client,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(): JsonResource
    {
        try {
            $facts = $this->client->request(HttpRequestAction::API_HTTP_METHOD, HttpRequestAction::API_URL);
        } catch (GuzzleException $e) {
            $this->logger->error('Request failed', ['error' => $e]);

            throw $e;
        }

        return new JsonResource(json_decode($facts->getBody()->getContents()));
    }
}
