<?php

require_once 'vendor/autoload.php';
require_once 'initialize.php';
require_once 'get_top_cryptocurrencies.php';
require_once 'buy_crypto.php';
require_once 'sell_crypto.php';
require_once 'wallet.php';
require_once 'transactions.php';

initializeFiles();

echo "Welcome to the Crypto Trading App!" . PHP_EOL;

while (true) {
    echo PHP_EOL . "Please choose an option:" . PHP_EOL;
    echo "1. List top cryptocurrencies" . PHP_EOL;
    echo "2. Buy cryptocurrency" . PHP_EOL;
    echo "3. Sell cryptocurrency" . PHP_EOL;
    echo "4. View wallet" . PHP_EOL;
    echo "5. View transaction history" . PHP_EOL;
    echo "6. Exit" . PHP_EOL;
    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case 1:
            getTopCryptocurrencies();
            break;

        case 2:
            echo "Enter the ticker symbol of the cryptocurrency you want to buy: ";
            $symbol = trim(fgets(STDIN));
            echo "Enter the amount in USD: ";
            $amount = trim(fgets(STDIN));
            $result = buyCrypto($symbol, (float)$amount);
            echo $result;
            break;

        case 3:
            echo "Enter the ticker symbol of the cryptocurrency you want to sell: ";
            $symbol = trim(fgets(STDIN));
            echo "Enter the quantity to sell: ";
            $quantity = trim(fgets(STDIN));
            $result = sellCrypto($symbol, (float)$quantity);
            echo $result;
            break;

        case 4:
            getWallet();
            break;

        case 5:
            getTransactions();
            break;

        case 6:
            exit("Goodbye!" . PHP_EOL);

        default:
            echo "Invalid choice. Please try again." . PHP_EOL;
    }
}