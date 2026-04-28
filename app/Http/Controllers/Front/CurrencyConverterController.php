<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

        $currencyCode = $request->input('currency_code');
        $baseCurrencyCode = config('app.currency', 'USD');
        $cashKey = 'currency_rate_'.$currencyCode;

        $rate = Cache::get($cashKey, 0);
        if (! $rate) {
            $converter = app('currency.converter');
            $rate = $converter->convert($baseCurrencyCode, $currencyCode);
            Cache::put($cashKey, $rate, now()->addMinutes(60));
        }
        Session::put('currency_code', $currencyCode);

        return redirect()->back();
    }
}
