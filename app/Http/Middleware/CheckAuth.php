<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek session user
        if (!$request->session()->has('user')) {
            return redirect('/');
        }

        return $next($request);
    }
}