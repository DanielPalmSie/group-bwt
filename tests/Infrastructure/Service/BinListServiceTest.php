<?php

namespace Infrastructure\Service;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Project\Daniel\Infrastructure\Facroty\ClientFactory;
use Project\Daniel\Infrastructure\Service\BinListService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class BinListServiceTest extends TestCase
{
    public function testGetCountryCodeByBin()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['country' => ['alpha2' => 'US']]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $clientFactory = $this->createMock(ClientFactory::class);
        $clientFactory->method('create')->willReturn($client);

        $binListService = new BinListService('https://lookup.binlist.net/', $clientFactory);
        $countryCode = $binListService->getCountryCodeByBin('123456');

        $this->assertEquals('US', $countryCode);
    }

    public function testGetCountryCodeByBinHandlesRequestException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error fetching BIN data');

        $mock = new MockHandler([
            new RequestException("Error", new Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $clientFactory = $this->createMock(ClientFactory::class);
        $clientFactory->method('create')->willReturn($client);

        $binListService = new BinListService('https://lookup.binlist.net/', $clientFactory);
        $binListService->getCountryCodeByBin('123456');
    }
}