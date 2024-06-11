<?php

function searchCryptoBySymbol(string $symbol): ?array
{
    $apiKey = 'man_jaiemacas_so_paslept';
    $baseUrl = 'https://pro-api.coinmarketcap.com/v1/';
    $url = $baseUrl . 'cryptocurrency/quotes/latest';
    $params = [
        'symbol' => $symbol,
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
    $data = json_decode($response, true);

    return $data['data'][$symbol] ?? null;
}
