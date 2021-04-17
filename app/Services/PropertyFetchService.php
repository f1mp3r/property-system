<?php

namespace App\Services;

use App\Contracts\PropertyFetchContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class PropertyFetchService implements PropertyFetchContract
{
    private LoggerInterface $logger;
    private string $endpoint;
    private string $apiKey;

    public function __construct()
    {
        $this->logger = Log::channel('property');
        $this->endpoint = env('API_ENDPOINT');
        $this->apiKey = env('API_KEY');
    }

    public function fetch($page, $perPage = 100): array
    {
        $params = [
            'api_key' => $this->apiKey,
            'page' => [
                'number' => $page,
                'size' => $perPage,
            ]
        ];

        $id = uniqid(); // To identify the request in logs

        $this->logger->debug(
            sprintf('[%s] Sending request to %s', $id, $this->endpoint),
            $params
        );

        $response = Http::retry(3, 100)->get($this->endpoint, $params);

        if ($response->failed()) {
            $this->logger->error(sprintf('[%s] Request failed', $id));
            return [];
        }

        $this->logger->debug(sprintf('[%s] Request done', $id));

        return $response->json();
    }
}
