<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
{
    if (!session()->has('auth_token')) {
        return redirect('/login');
    }

    if (session('rol') !== $role) {
        abort(403);
    }

    return $next($request);
}
}