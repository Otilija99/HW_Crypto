<?php

require_once 'search_crypto.php';
require_once 'log_transaction.php';

function sellCrypto(string $symbol, float $quantity): string
{
    $crypto = searchCryptoBySymbol($symbol);
    if (!$crypto) {
        return "Cryptocurrency not found" . PHP_EOL;
    }

    $price = $crypto['quote']['USD']['price'];
    $amountUsd = $quantity * $price;

    $wallet = json_decode(file_get_contents('wallet.json'), true);
    if (!isset($wallet[$symbol]) || $wallet[$symbol] < $quantity) {
        return "Insufficient quantity" . PHP_EOL;
    }

    $wallet['USD'] += $amountUsd;
    $wallet[$symbol] -= $quantity;
    if ($wallet[$symbol] == 0) {
        unset($wallet[$symbol]);
    }

    file_put_contents('wallet.json', json_encode($wallet, JSON_PRETTY_PRINT));

    $transaction = [
        'type' => 'sell',
        'symbol' => $symbol,
        'quantity' => $quantity,
        'price' => $price,
        'amount_usd' => $amountUsd,
        'timestamp' => time(),
    ];
    logTransaction($transaction);

    return "Sell successful" . PHP_EOL;
}
