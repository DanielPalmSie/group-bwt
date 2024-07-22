<?php

namespace Project\Daniel\Application\Factory;

use Project\Daniel\Application\Main;
use Project\Daniel\Infrastructure\Facroty\ClientFactory;
use Project\Daniel\Infrastructure\Service\BinListService;
use Project\Daniel\Infrastructure\Service\ExchangeRateService;
use Project\Daniel\Domain\Service\CommissionCalculator;

readonly class AppFactory implements AppFactoryInterface
{
    public function __construct(
        private string $binListUrl,
        private string $exchangeRateUrl
    )
    {

    }

    public function createMain(): Main
    {
        $currencyFormatterFactory = new CurrencyFormatterFactory();
        return new Main($this->createCommissionCalculator(), $currencyFormatterFactory);
    }

    public function createCommissionCalculator(): CommissionCalculator
    {
        $clientFactory = new ClientFactory();
        $binListService = new BinListService($this->binListUrl, $clientFactory);
        $exchangeRateService = new ExchangeRateService($this->exchangeRateUrl, $clientFactory);
        return new CommissionCalculator($binListService, $exchangeRateService);
    }
}