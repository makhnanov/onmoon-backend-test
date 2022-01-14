<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Currency;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use TypeError;

class SaveRates extends CbrfSaver
{
    protected $signature = 'save:rates';

    protected $description = 'Save rates';

    public function handle()
    {
        $allCurrency = Currency::all(['code', 'ru']);
        $allCurrencyCount = count($allCurrency);
        foreach ($allCurrency as $rateIndex => $model) {
//            if ($rateIndex < 18) {
//                continue;
//            }
            echo $model->code . ' ' . $model->ru . ' ';

            $uri = 'XML_dynamic.asp?date_req1=02/03/1900&date_req2=14/03/'
                . (date('Y') + 1)
                . '&VAL_NM_RQ='
                . $model->code;

            try {
                $decodedData = $this->fetchDataFromCbrf($uri, 'Record');
            } catch (TypeError $e) {
                echo 'Has not got data!' . PHP_EOL;
                continue;
            }

            try {
                Schema::create($model->code, function (Blueprint $table) {
                    $table->id();
                    $table->date('date')->unique();
                    $table->float('nominal')->nullable(false);
                    $table->float('value')->nullable(false);
                    $table->string('code')->nullable(false);
                });
            } catch (\Throwable $e) {
                // silent
            }

            $allRecords = [];

            $codesDifferent = 0;
            foreach ($decodedData as $record) {

                if ($record['@attributes']['Id'] !== $model->code) {
                    $codesDifferent++;
                }

                $timestamp = DateTime::createFromFormat(
                    'd.m.Y',
                    $record['@attributes']['Date'] ?? self::throwEmpty()
                )->getTimestamp();

                $allRecords[$timestamp] = [
                    'date' => date('Y-m-d', $timestamp),
                    'nominal' => $record['Nominal'] ?? self::throwEmpty(),
                    'value' => ((float)str_replace( ',', '.', $record['Value'])) ?? self::throwEmpty(),
                    'code' => $record['@attributes']['Id'] ?? self::throwEmpty(),
                ];
            }
            $previousNominal = 0;
            $previousValue = 0;
            $allTimestamps = array_keys($allRecords);
            $previousCode = '';
            $max = max($allTimestamps);
            for ($i = min($allTimestamps); $i < $max; $i = strtotime('+1 day', $i)) {
                if (!isset($allRecords[$i])) {
                    $allRecords[$i] = [
                        'date' => date('Y-m-d', $i),
                        'nominal' => $previousNominal,
                        'value' => $previousValue,
                        'code' => $previousCode,
                    ];
                }
                $previousNominal = $allRecords[$i]['nominal'];
                $previousValue = $allRecords[$i]['value'];
                $previousCode = $allRecords[$i]['code'];
            }

            ksort($allRecords);

            try {
                echo count($allRecords) . ' ' . ($rateIndex + 1) . ' / ' . $allCurrencyCount . ' ';
                if ($codesDifferent) {
                    echo "Have $codesDifferent different codes. ";
                }
                echo DB::table($model->code)->insert(array_values($allRecords)) ? 'OK' : 'FAIL';

            } catch (QueryException $e) {
//                echo $e->getMessage();
                echo 'QueryException';

            } finally {
                echo PHP_EOL;
            }

            sleep(20);
        }
    }
}
