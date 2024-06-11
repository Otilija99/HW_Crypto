<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

function getWallet(): array
{
    $wallet = json_decode(file_get_contents('wallet.json'), true);

    $output = new ConsoleOutput();
    $table = new Table($output);
    $table
        ->setHeaders(['Currency', 'Amount'])
        ->setRows(array_map(static function (string $currency, float $amount): array {
            return [$currency, $amount];
        }, array_keys($wallet), $wallet));
    $table->render();

    return $wallet;
}
