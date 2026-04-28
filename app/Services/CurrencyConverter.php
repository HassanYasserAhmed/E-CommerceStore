<?php

namespace App\Services;

use App\Exceptions\CustomErrorException;
use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl = 'https://api.fastforex.io';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert($from, $to, $amount = 1)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->get('fetch-one', [
                'api_key' => $this->apiKey,
                'from' => $from,
                'to' => $to,
            ]);

        $result = $response->json();
        if ($result['error']) {
            throw new CustomErrorException($result['error']);
        }

        return $result['result'][$to] * $amount;
    }
}
