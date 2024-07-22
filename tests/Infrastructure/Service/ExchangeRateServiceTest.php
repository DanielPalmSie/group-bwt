<?php

namespace Infrastructure\Service;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Project\Daniel\Infrastructure\Facroty\ClientFactory;
use Project\Daniel\Infrastructure\Service\ExchangeRateService;

class ExchangeRateServiceTest extends TestCase
{
    public function testGetRateReturnsCorrectRate()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['rates' => ['USD' => 1.2]]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $clientFactory = $this->createMock(ClientFactory::class);
        $clientFactory->method('create')->willReturn($client);

        $exchangeRateService = new ExchangeRateService('https://api.exchangeratesapi.io/latest', $clientFactory);
        $rate = $exchangeRateService->getRate('USD');

        $this->assertEquals(1.2, $rate);
    }

    public function testGetRateHandlesRequestException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error fetching exchange rate data');

        $mock = new MockHandler([
            new RequestException("Error", new Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $clientFactory = $this->createMock(ClientFactory::class);
        $clientFactory->method('create')->willReturn($client);

        $exchangeRateService = new ExchangeRateService('https://api.exchangeratesapi.io/latest', $clientFactory);
        $exchangeRateService->getRate('USD');
    }
}