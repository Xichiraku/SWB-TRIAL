<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login (pakai session)
        if (!session('user')) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        // Cek role user (dari session)
        if (session('user')['role'] !== $role) {
            return redirect()->route('login')->withErrors(['login' => 'Akses ditolak. Anda tidak memiliki izin.']);
        }

        return $next($request);
    }
}