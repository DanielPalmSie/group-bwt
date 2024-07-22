<?php

namespace Project\Daniel\Application\Factory;

use Money\Currencies;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\MoneyFormatter;

class CurrencyFormatterFactory implements CurrencyFormatterFactoryInterface
{
    public function createCurrencies(): Currencies
    {
        return new ISOCurrencies();
    }

    public function createMoneyFormatter(Currencies $currencies): MoneyFormatter
    {
        return new DecimalMoneyFormatter($currencies);
    }
}