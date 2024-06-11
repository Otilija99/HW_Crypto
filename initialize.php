<?php

function initializeFiles(): void
{
    if (!file_exists('wallet.json')) {
        file_put_contents('wallet.json', json_encode(['USD' => 1000], JSON_PRETTY_PRINT));
    }
    if (!file_exists('transactions.json')) {
        file_put_contents('transactions.json', json_encode([], JSON_PRETTY_PRINT));
    }
}
