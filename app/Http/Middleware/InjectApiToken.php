<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\ExternalApi\HttpClient;

class InjectApiToken
{
    /**
     * Inject the session token into the HttpClient before the request reaches the controller.
     */
    public function handle($request, Closure $next)
    {
        
    if (session()->has('auth_token')) {
    app(\App\Services\ExternalApi\HttpClient::class)
        ->setToken(session('auth_token'));
}

    return $next($request);
    }
}
?>
