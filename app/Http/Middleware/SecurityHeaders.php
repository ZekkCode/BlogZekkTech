<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Frame/Clickjacking protection
        if (!$response->headers->has('X-Frame-Options')) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        }

        // MIME sniffing
        if (!$response->headers->has('X-Content-Type-Options')) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
        }

        // Referrer policy
        if (!$response->headers->has('Referrer-Policy')) {
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        // Permissions Policy (formerly Feature-Policy)
        if (!$response->headers->has('Permissions-Policy')) {
            $response->headers->set('Permissions-Policy', "geolocation=(), microphone=(), camera=()");
        }

        // Content Security Policy (minimal, adjust for inline styles/scripts if needed)
        if (!$response->headers->has('Content-Security-Policy')) {
            $csp = "default-src 'self'; img-src 'self' data: https:; script-src 'self'; style-src 'self' 'unsafe-inline'; font-src 'self' data:";
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Enforce HTTPS on clients (HSTS) when over HTTPS
        if ($request->isSecure() && !$response->headers->has('Strict-Transport-Security')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
