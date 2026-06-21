<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('token')) {

            return redirect()->route('login');

        }

        if (now()->timestamp >= session('token_expires_at')) {

            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Session login telah habis');

        }

        return $next($request);
    }
}