<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Log;

class DetectUserCurrency
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if currency is already set in session
        if (!session()->has('currency')) {
            try {
                $ip = $request->ip();
                $country = $this->currencyService->detectUserCountry($ip);
                
                if ($country === 'CO') {
                    session(['currency' => 'COP']);
                } else {
                    session(['currency' => 'USD']);
                }
            } catch (\Exception $e) {
                Log::error('Currency middleware error: ' . $e->getMessage());
                session(['currency' => 'USD']);
            }
        }

        return $next($request);
    }
}
