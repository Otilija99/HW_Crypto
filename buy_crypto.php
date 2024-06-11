<?php

require_once 'search_crypto.php';
require_once 'log_transaction.php';

function buyCrypto(string $symbol, float $amountUsd): string
{
    $crypto = searchCryptoBySymbol($symbol);
    if (!$crypto) {
        return "Cryptocurrency not found" . PHP_EOL;
    }

    $price = $crypto['quote']['USD']['price'];
    $quantity = $amountUsd / $price;

    $wallet = json_decode(file_get_contents('wallet.json'), true);
    if ($wallet['USD'] < $amountUsd) {
        return "Insufficient funds" . PHP_EOL;
    }

    $wallet['USD'] -= $amountUsd;
    if (isset($wallet[$symbol])) {
        $wallet[$symbol] += $quantity;
    } else {
        $wallet[$symbol] = $quantity;
    }

    file_put_contents('wallet.json', json_encode($wallet, JSON_PRETTY_PRINT));

    $transaction = [
        'type' => 'buy',
        'symbol' => $symbol,
        'quantity' => $quantity,
        'price' => $price,
        'amount_usd' => $amountUsd,
        'timestamp' => time(),
    ];
    logTransaction($transaction);

    return "Purchase successful" . PHP_EOL;
}
