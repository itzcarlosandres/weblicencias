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
        // Check for manual override first
        if ($request->has('currency')) {
            $currency = strtoupper($request->get('currency'));
            if (in_array($currency, ['USD', 'COP', 'MXN', 'EUR'])) {
                session(['currency' => $currency]);
                
                // Remove currency parameter from URL
                $url = $request->url();
                $query = $request->except('currency');
                if (!empty($query)) {
                    $url .= '?' . http_build_query($query);
                }
                
                return redirect($url);
            }
        }

        // Check if currency is already set in session
        if (!session()->has('currency')) {
            try {
                $ip = $request->ip();
                // We'll use the ipapi.co directly inside CurrencyService
                $country = 'US';
                if ($ip !== '127.0.0.1' && $ip !== '::1') {
                    $response = \Illuminate\Support\Facades\Http::timeout(3)->get("https://ipapi.co/{$ip}/country/");
                    $country = $response->successful() ? $response->body() : 'US';
                }
                
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
