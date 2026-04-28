<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CustomErrorException extends Exception
{
    public function __construct(protected $message) {}

    public function render()
    {
        return redirect()->route('home')->with([
            'message' => 'There Are A Problem In Convert Currency Pleas Try Again Later',
        ]
        );
    }

    public function report()
    {
        Log::error($this->getMessage());
    }
}
