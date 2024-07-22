<?php

namespace Project\Daniel\Domain\Service;

interface ExchangeRateServiceInterface
{
    public function getRate(string $currency): float;
}