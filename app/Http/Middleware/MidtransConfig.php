<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MidtransConfig
{
    public function handle(Request $request, Closure $next)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        return $next($request);
    }
}
