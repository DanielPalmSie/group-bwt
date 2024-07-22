<?php

namespace Project\Daniel\Application\Factory;

use Money\Currencies;
use Money\MoneyFormatter;


interface CurrencyFormatterFactoryInterface
{
    public function createCurrencies(): Currencies;
    public function createMoneyFormatter(Currencies $currencies): MoneyFormatter;
}