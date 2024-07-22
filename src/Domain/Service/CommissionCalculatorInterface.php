<?php

namespace Project\Daniel\Domain\Service;

use Money\Money;

interface CommissionCalculatorInterface
{
    public function calculate(Money $money, string $bin): Money;
}