<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
{
    if (!session()->has('rol')) {
        abort(403, 'No autorizado');
    }

    if (session('rol') !== $role) {
        abort(403, 'No autorizado');
    }

    return $next($request);
}
}