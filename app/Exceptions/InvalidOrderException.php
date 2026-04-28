<?php

namespace App\Exceptions;

use Exception;

class InvalidOrderException extends Exception
{
    public function render()
    {
        return redirect()->route('home')->with([

            'message' => $this->getMessage(),
        ]
        );
    }
}
