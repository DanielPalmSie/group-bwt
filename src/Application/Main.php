<?php

namespace Project\Daniel\Application;

use Money\Currencies;
use Money\Money;
use Money\Currency;
use Money\MoneyFormatter;
use Project\Daniel\Application\Factory\CurrencyFormatterFactoryInterface;
use Project\Daniel\Domain\Service\CommissionCalculatorInterface;

class Main
{
    private Currencies $currencies;
    private MoneyFormatter $formatter;

    public function __construct(
        private readonly CommissionCalculatorInterface $commissionCalculator,
        CurrencyFormatterFactoryInterface $currencyFormatterFactory
    ) {
        $this->currencies = $currencyFormatterFactory->createCurrencies();
        $this->formatter = $currencyFormatterFactory->createMoneyFormatter($this->currencies);
    }

    public function run(string $inputFile): void
    {
        $transactions = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($transactions as $transaction) {
            $transactionData = json_decode($transaction, true);
            $bin = $transactionData['bin'];
            $amount = $transactionData['amount'];
            $currency = $transactionData['currency'];

            $money = new Money((int) ($amount * 100), new Currency($currency));
            $commission = $this->commissionCalculator->calculate($money, $bin);

            echo $this->formatter->format($commission) . "\n";
        }
    }
}