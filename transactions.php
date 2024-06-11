<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

function getTransactions(): array
{
    $transactions = json_decode(file_get_contents('transactions.json'), true);

    $output = new ConsoleOutput();
    $table = new Table($output);
    $table
        ->setHeaders(['Type', 'Symbol', 'Quantity', 'Price (USD)', 'Amount (USD)', 'Timestamp'])
        ->setRows(array_map(static function (array $transaction): array {
            return [
                $transaction['type'],
                $transaction['symbol'],
                $transaction['quantity'],
                $transaction['price'],
                $transaction['amount_usd'],
                date('Y-m-d H:i:s', $transaction['timestamp']),
            ];
        }, $transactions));
    $table->render();

    return $transactions;
}
