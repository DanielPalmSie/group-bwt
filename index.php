<?php

require 'vendor/autoload.php';

use Project\Daniel\Application\Factory\AppFactory;

$binListUrl = 'https://lookup.binlist.net/';
$exchangeRateUrl = 'https://api.exchangeratesapi.io/latest';

$appFactory = new AppFactory($binListUrl, $exchangeRateUrl);
$main = $appFactory->createMain();
$main->run($argv[1]);