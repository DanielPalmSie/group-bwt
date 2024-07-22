<?php

namespace Project\Daniel\Application\Factory;

use Project\Daniel\Application\Main;
use Project\Daniel\Domain\Service\CommissionCalculatorInterface;

interface AppFactoryInterface
{
    public function createMain(): Main;
    public function createCommissionCalculator(): CommissionCalculatorInterface;
}