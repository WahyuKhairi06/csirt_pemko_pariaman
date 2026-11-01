<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Header keamanan untuk RUTE PUBLIK saja (PRD.md bagian 9.1).
 *
 * - Jangan dipasang pada panel admin: Filament/Livewire memakai skrip dan gaya inline yang akan diblokir CSP ketat ini.
 * - Tanpa 'unsafe-inline' dan 'unsafe-eval': hindari <script> dan style="" inline di Blade publik, pakai berkas JS/CSS
 *   hasil Vite. Alpine.js versi standar butuh 'unsafe-eval'; pakai build CSP-nya (@alpinejs/csp; periksa dokumen Alpine)
 *   atau JavaScript biasa untuk menu mobile dan tombol Salin.
 * - Embed video (FR-21): hanya YouTube mode privasi yang diizinkan di frame-src.
 */
class PublicSecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self'",
            "style-src 'self'",
            "img-src 'self' data:",
            "font-src 'self'",
            "connect-src 'self'",
            'frame-src https://www.youtube-nocookie.com',
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
