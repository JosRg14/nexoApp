<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login');
        }

        $token = session('auth_token');

        // Petición a la API para obtener los datos actualizados
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get(config('services.api.url') . '/api/me');

        if ($response->successful()) {
            $data = $response->json()['data']['usuario'] ?? [];
            $rol = $data['rol'] ?? session('rol');
            
            // Lógica para formatear el nombre según el rol
            if ($rol === 'cliente' && isset($data['cliente'])) {
                $cliente = $data['cliente'];
                $nombre = $cliente['nombre'] ?? '';
                $paterno = $cliente['app_paterno'] ?? '';
                $materno = $cliente['app_materno'] ?? '';
                
                $data['nombre_completo'] = trim("$nombre $paterno $materno");
                $data['nombre'] = $nombre;
                $data['telefono'] = $cliente['telefono'] ?? null;
            } elseif ($rol === 'admin') {
                $data['nombre'] = explode(' ', $data['nombre_completo'] ?? '')[0] ?? 'Usuario';
            }

            // Actualizar la sesión para que otros lugares tengan los datos actualizados
            session(['usuario' => array_merge(session('usuario', []), $data)]);
        }

        $usuario = session('usuario');
        $rol = session('rol');

        return view('profile', compact('usuario', 'rol'));
    }
}
