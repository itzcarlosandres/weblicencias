<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlacklist
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Avoid blocking admin routes to prevent locking out the administrator
        if ($request->is('admin*') || $request->is('login')) {
            return $next($request);
        }

        $ip = $request->ip();

        if ($ip && !in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            $blacklistedIps = \Illuminate\Support\Facades\Cache::remember('blacklisted_ips', 60 * 60, function () {
                return \App\Models\Blacklist::where('type', 'ip')->pluck('value')->toArray();
            });

            if (in_array($ip, $blacklistedIps)) {
                abort(403, 'Acceso denegado. Tu dirección IP ha sido bloqueada por motivos de seguridad.');
            }
        }

        return $next($request);
    }
}
