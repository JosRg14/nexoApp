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

            // --- CASO 2: NEGOCIO EN ESPERA O PENDIENTE ---
            if ($negocio && isset($negocio['estado']) && in_array($negocio['estado'], ['pendiente_pago', 'en_revision'])) {
                if (!$request->routeIs('registro.negocio.espera')) {
                    return redirect()->route('registro.negocio.espera');
                }
                return $next($request);
            }

            // --- CASO 3: NEGOCIO ACTIVO ---
            if ($negocio && isset($negocio['estado']) && $negocio['estado'] === 'activo') {
                // Si intenta volver atrás al registro o a la espera, lo mandamos al profile
                if ($request->routeIs('registro.negocio.paso2') || $request->routeIs('registro.negocio.espera')) {
                    return redirect()->route('business.profile');
                }
                return $next($request);
            }

            // --- CASO 4: TIENE NEGOCIO PERO SIN PLAN ACTIVO (VALIDACIÓN FALLBACK) ---
            // La API devuelve success: true Y data: null
            if (isset($res['success']) && $res['success'] === true && is_null($negocio)) {
                if (!$request->routeIs('registro.negocio.espera')) {
                    return redirect()->route('registro.negocio.espera');
                }
                return $next($request);
            }

        } catch (\Exception $e) {
            \Log::error('Error Middleware Suscripción: ' . $e->getMessage());
        }

        return $next($request);
    }
}