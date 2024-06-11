<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

function getTopCryptocurrencies(int $limit = 10): array
{
    $apiKey = 'man_jaiemacas_so_paslept';
    $baseUrl = 'https://pro-api.coinmarketcap.com/v1/';
    $url = $baseUrl . 'cryptocurrency/listings/latest';
    $params = [
        'start' => '1',
        'limit' => $limit,
        'convert' => 'USD',
    ];
    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: ' . $apiKey,
    ];
    $query = http_build_query($params);
    $ch = curl_init("$url?$query");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true)['data'];

    $output = new ConsoleOutput();
    $table = new Table($output);
    $table
        ->setHeaders(['Name', 'Symbol', 'Price (USD)'])
        ->setRows(array_map(static function (array $crypto): array {
            return [$crypto['name'], $crypto['symbol'], $crypto['quote']['USD']['price']];
        }, $data));
    $table->render();

    return $data;
}
