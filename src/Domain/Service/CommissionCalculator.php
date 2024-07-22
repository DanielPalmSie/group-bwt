<?php

namespace Project\Daniel\Domain\Service;

use Money\Money;
use Money\Currency;

readonly class CommissionCalculator implements CommissionCalculatorInterface
{
    public function __construct(
        private BinListServiceInterface      $binListService,
        private ExchangeRateServiceInterface $exchangeRateService)
    {
    }

    public function calculate(Money $money, string $bin): Money
    {
        $countryCode = $this->binListService->getCountryCodeByBin($bin);
        $isEu = $this->isEu($countryCode);

        if ($money->getCurrency()->getCode() === 'EUR') {
            $amountFixed = $money;
        } else {
            $rate = $this->exchangeRateService->getRate($money->getCurrency()->getCode());

            if ($rate == 0) {
                throw new \Exception("Exchange rate for " . $money->getCurrency()->getCode() . " cannot be zero.");
            }

            $convertedAmount = (int) ($money->getAmount() / $rate);
            $amountFixed = new Money($convertedAmount, new Currency('EUR'));
        }

        $commissionRate = $isEu ? 0.01 : 0.02;
        return $amountFixed->multiply($commissionRate);
    }

    private function isEu(string $countryCode): bool
    {
        $euCountries = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR',
            'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO',
            'SE', 'SI', 'SK'
        ];

        return in_array($countryCode, $euCountries);
    }
}