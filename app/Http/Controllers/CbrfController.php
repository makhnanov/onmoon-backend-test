<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class CbrfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function rate()
    {
        $code = request('code');

        $validCodes = array_map(function ($value) {
            return $value['code'];
        }, Currency::all('code')->toArray());

        if (!$code || !is_string($code) || !in_array($code, $validCodes, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Need code',
            ]);
        }

        $from = request('from');
        if (
            $from
            && (
                !is_string($from)
                || $this->isDataInvalid($from)
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'From data invalid',
            ]);
        }

        $to = request('to');
        if (
            $to
            && (
                !is_string($to)
                || $this->isDataInvalid($to)
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'To data invalid',
            ]);
        }

        $columns = ['code', 'date', 'nominal', 'value'];

        $common = DB::table($code)
            ->select($columns);

        if (!$from && !$to) {
            $rateRecord = $common->orderByDesc('date')->limit(1)->first();
            return response()->json([
                'success' => true,
                'code' => $rateRecord->code,
                'date' => $rateRecord->date,
                'nominal' => $rateRecord->nominal,
                'value' => $rateRecord->value,
            ]);
        }

        $maxForYear = $common->limit(365);

        if (!$from && $to) {
            $oldest = $maxForYear->orderByDesc('date')->where([['date', '<=', $to]])->get($columns);
            return response()->json([
                'success' => true,
                'items' => $oldest
            ]);
        }

        if ($from && !$to) {
            $newest = $maxForYear->orderBy('date')->where([['date', '>=', $from]])->get($columns);
            return response()->json([
                'success' => true,
                'items' => $newest
            ]);
        }

        if ($from && $to) {
            $newest = $maxForYear
                ->orderBy('date')
                ->where([['date', '>=', $from], ['date', '<=', $to]])
                ->get($columns);
            return response()->json([
                'success' => true,
                'items' => $newest
            ]);
        }
    }

    private function isDataInvalid(string $date): bool
    {
        $test_arr  = explode('-', $date);
        if (!checkdate($test_arr[1] ?? 0, $test_arr[2] ?? 0, $test_arr[0] ?? 0)) {
            return true;
        }
        return false;
    }
}
