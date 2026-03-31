<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckBusinessSuscripcion
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('auth_token');
        if (!$token) {
            return redirect()->route('login');
        }

        try {
            $response = Http::withToken($token)
                ->withoutVerifying()
                ->get('https://devlink-servidorapi.td60xq.easypanel.host/api/mi-suscripcion');
            
            $res = $response->json();
            $negocio = $res['data'] ?? null;

            // --- CASO 1: NO TIENE NEGOCIO REGISTRADO ---
            // La API devuelve success: false
            if (isset($res['success']) && $res['success'] === false) {
                if (!$request->routeIs('registro.negocio.paso2') && !$request->routeIs('registro.negocio.save')) {
                    return redirect()->route('registro.negocio.paso2');
                }
                return $next($request);
            }

            // --- CASO 2: TIENE NEGOCIO PERO SIN PLAN ACTIVO (VALIDACIÓN) ---
            // La API devuelve success: true Y data: null
            if ($res['success'] === true && is_null($negocio)) {
                // Si no está ya en la vista de espera, lo mandamos allá
                if (!$request->routeIs('registro.negocio.espera')) {
                    return redirect()->route('registro.negocio.espera');
                }
                return $next($request);
            }

            // --- CASO 3: PLAN ACTIVO ---
            // La API devuelve data con estado => 'activo'
            if ($negocio && isset($negocio['estado']) && $negocio['estado'] === 'activo') {
                // Si intenta volver atrás al registro o a la espera, lo mandamos al profile
                if ($request->routeIs('registro.negocio.paso2') || $request->routeIs('registro.negocio.espera')) {
                    return redirect()->route('business.profile');
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error Middleware Suscripción: ' . $e->getMessage());
        }

        return $next($request);
    }
}