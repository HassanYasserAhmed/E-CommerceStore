<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use CurrencyConverterService;
use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    public function __construct(protected CurrencyConverterService $currencyConverterService) {}
    public function store(Request $request)
    {
       $data= $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

       $this->currencyConverterService->store($data);
       
        return redirect()->back();
    }
}
