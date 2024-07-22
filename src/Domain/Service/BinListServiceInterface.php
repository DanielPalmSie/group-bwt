<?php

namespace Project\Daniel\Domain\Service;

interface BinListServiceInterface
{
    public function getCountryCodeByBin(string $bin): string;
}