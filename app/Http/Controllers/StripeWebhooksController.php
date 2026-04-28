<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhooksController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        Log::debug('webhook event received', json_decode($payload, true));
    }
}
