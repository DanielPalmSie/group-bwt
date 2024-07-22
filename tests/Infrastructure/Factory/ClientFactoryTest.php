<?php

namespace Infrastructure\Factory;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Project\Daniel\Infrastructure\Facroty\ClientFactory;

class ClientFactoryTest extends TestCase
{
    public function testCreateReturnsClientInstance()
    {
        $clientFactory = new ClientFactory();
        $client = $clientFactory->create();
        $this->assertInstanceOf(Client::class, $client);
    }
}