<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

abstract class CbrfSaver extends Command
{
    public function fetchDataFromCbrf(string $uri, $key)
    {
        $client = new Client(['base_uri' => 'https://www.cbr.ru/scripts/']);
        $result = $client->get($uri);
        $xmlElement = simplexml_load_string(
            $result->getBody()->getContents(),
            "SimpleXMLElement",
            LIBXML_NOCDATA
        );
        $decoded = json_decode(json_encode($xmlElement), true)[$key] ?? null;
        if (!$decoded) {
            throw new \TypeError('There are no keys.');
        }
        return $decoded;
    }

    protected static function throwEmpty()
    {
        throw new \Exception('Data not found.');
    }
}
