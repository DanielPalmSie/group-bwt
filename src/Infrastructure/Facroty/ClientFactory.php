<?php

namespace Project\Daniel\Infrastructure\Facroty;

use GuzzleHttp\Client;

class ClientFactory
{
    public function create(): Client
    {
        return new Client();
    }
}