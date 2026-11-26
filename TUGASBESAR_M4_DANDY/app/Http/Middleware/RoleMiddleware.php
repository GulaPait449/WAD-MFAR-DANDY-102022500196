<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // pengguna sudah login atau blm
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Memeriksa apakah role pengguna sesuai
        if (!in_array(auth()->user()->role, $roles)) { //$roles: nampung beberapa role
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request); //izinin permintaan lanjut
    }
}
