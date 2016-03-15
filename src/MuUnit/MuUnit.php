<?php

require __DIR__ . '/../../vendor/autoload.php';

echo 'MuUnit v1.0.0' . PHP_EOL . PHP_EOL;

$test = new \Trident\Tests\IndexTest();

$stats = $test->__runTests();

echo PHP_EOL . PHP_EOL . json_encode($stats, JSON_PRETTY_PRINT) . PHP_EOL;

exit($stats->fails > 0 ? 1 : 0);

