<?php

function logTransaction(array $transaction): void
{
    $transactions = json_decode(file_get_contents('transactions.json'), true);
    $transactions[] = $transaction;
    file_put_contents('transactions.json', json_encode($transactions, JSON_PRETTY_PRINT));
}
