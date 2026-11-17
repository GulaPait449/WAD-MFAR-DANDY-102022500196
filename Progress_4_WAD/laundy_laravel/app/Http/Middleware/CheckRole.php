<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Role tidak ada
        if (! $request->user()->hasRole(...$roles)) {
            abort(403);
        }

        return $next($request);
    }
}