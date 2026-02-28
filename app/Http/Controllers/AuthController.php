<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    
public function login(Request $request)
{
    $response = Http::post(config('services.api.url') . '/api/login', [
        'correo' => $request->email,
        'contrasena' => $request->password,
    ]);

    if (!$response->successful()) {
        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $data = $response->json();

    // Validamos que venga la estructura correcta
    if (!isset($data['data']['token']) || !isset($data['data']['rol'])) {
        return response()->json([
            'message' => 'Respuesta inesperada del servidor'
        ], 500);
    }

    // Guardamos en sesión
    session([
        'auth_token' => $data['data']['token'],
        'rol' => $data['data']['rol'],
        'usuario' => $data['data']['usuario'],
    ]);

    // Devolvemos solo la redirección
    return response()->json([
        'redirect' => match ($data['data']['rol']) {
            'superusuario' => '/dashboard',
            'admin' => '/business/profile',
            default => '/',
        }
    ]);
}
}