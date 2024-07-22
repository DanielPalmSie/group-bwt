<?php

namespace Project\Daniel\Infrastructure\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Project\Daniel\Domain\Service\BinListServiceInterface;
use Project\Daniel\Infrastructure\Facroty\ClientFactory;

class BinListService implements BinListServiceInterface
{
    private Client $httpClient;

    public function __construct(private readonly string $baseUrl, ClientFactory $clientFactory)
    {
        $this->httpClient = $clientFactory->create();
    }

    public function getCountryCodeByBin(string $bin): string
    {
        try {
            $response = $this->httpClient->get($this->baseUrl . $bin);
            $data = json_decode($response->getBody(), true);
            return $data['country']['alpha2'];
        } catch (RequestException $e) {
            throw new \Exception('Error fetching BIN data');
        }
    }
}