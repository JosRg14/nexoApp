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
            $token = session('auth_token');
            // Log para depeguar la existencia del token
            \Illuminate\Support\Facades\Log::info('InjectApiToken: Token encontrado en sesión.', ['token_length' => strlen($token)]);
            
            app(\App\Services\ExternalApi\HttpClient::class)->setToken($token);
        } else {
            \Illuminate\Support\Facades\Log::warning('InjectApiToken: No se encontró auth_token en la sesión.');
        }

        return $next($request);
    }
}
?>
