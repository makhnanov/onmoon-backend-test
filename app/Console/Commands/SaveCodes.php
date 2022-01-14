<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Currency;

class SaveCodes extends CbrfSaver
{
    protected $signature = 'save:codes';

    protected $description = 'Save codes';

    public function handle()
    {
        $decodedData = $this->fetchDataFromCbrf('XML_val.asp?d=0', 'Item');
        $currencyList = [];
        foreach ($decodedData as $value) {
            $currencyList[] = [
                'code' => $value['@attributes']['ID'] ?? self::throwEmpty(),
                'ru' => $value['Name'] ?? self::throwEmpty(),
                'en' => $value['EngName'] ?? self::throwEmpty(),
                'nominal' => $value['Nominal'] ?? self::throwEmpty(),
            ];
        }
        Currency::insert($currencyList);
    }
}
