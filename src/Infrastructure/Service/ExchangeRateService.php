<?php

namespace Project\Daniel\Infrastructure\Service;

use Project\Daniel\Domain\Service\ExchangeRateServiceInterface;
use GuzzleHttp\Exception\RequestException;
use Project\Daniel\Infrastructure\Facroty\ClientFactory;
use GuzzleHttp\Client;

class ExchangeRateService implements ExchangeRateServiceInterface
{
    private Client $httpClient;

    public function __construct(private readonly string $baseUrl, ClientFactory $clientFactory)
    {
        $this->httpClient = $clientFactory->create();
    }

    public function getRate(string $currency): float
    {
        try {
            $response = $this->httpClient->get($this->baseUrl);
            $data = json_decode($response->getBody(), true);
            return $data['rates'][$currency] ?? 0;
        } catch (RequestException $e) {
            throw new \Exception('Error fetching exchange rate data');
        }
    }
}