<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo redirigir en el entorno de producción
        if (!app()->environment('production')) {
            return $next($request);
        }

        $canonicalUrl = config('app.url');
        if (empty($canonicalUrl)) {
            return $next($request);
        }

        $parsedCanonical = parse_url($canonicalUrl);
        $canonicalHost = $parsedCanonical['host'] ?? null;
        $canonicalScheme = $parsedCanonical['scheme'] ?? 'https';

        if (!$canonicalHost) {
            return $next($request);
        }

        $currentHost = $request->getHost();
        $isSecure = $request->secure(); // Detecta HTTPS real o HTTPS vía proxies de confianza

        $needsRedirect = false;

        // 1. Verificar esquema (si canonical indica https y el request no es seguro)
        if ($canonicalScheme === 'https' && !$isSecure) {
            $needsRedirect = true;
        }

        // 2. Verificar host (si no coincide con el host canónico como www vs no-www)
        if (strtolower($currentHost) !== strtolower($canonicalHost)) {
            $needsRedirect = true;
        }

        if ($needsRedirect) {
            $path = $request->getRequestUri(); // Conserva el path y la query string
            $redirectUrl = $canonicalScheme . '://' . $canonicalHost . $path;

            return redirect()->away($redirectUrl, 301);
        }

        return $next($request);
    }
}
