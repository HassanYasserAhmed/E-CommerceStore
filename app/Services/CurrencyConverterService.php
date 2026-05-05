<?php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterService {
    public function Store($data) {
         $currencyCode = $data->input('currency_code');
        $baseCurrencyCode = config('app.currency', 'USD');
        $cashKey = 'currency_rate_'.$currencyCode;

        $rate = Cache::get($cashKey, 0);
        if (! $rate) {
            $converter = app('currency.converter');
            $rate = $converter->convert($baseCurrencyCode, $currencyCode);
            Cache::put($cashKey, $rate, now()->addMinutes(60));
        }
        Session::put('currency_code', $currencyCode);

    }
}