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
        'superusuario' => route('dashboard.index'),
        'admin' => route('business.profile'),
        default => '/',
    }
]);

    
}

public function registerCliente(Request $request)
{
    $request->validate([
        'contrasena' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/'
        ],
        'correo' => 'required|email',
        'nombre' => 'required',
    ], [
        'contrasena.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.',
        'contrasena.confirmed' => 'Las contraseñas no coinciden.',
    ]);

    $response = Http::withHeaders([
        'Accept' => 'application/json'
    ])->post(
        config('services.api.url') . '/api/register/cliente',
        [
            'nombre' => $request->nombre,
            'app_paterno' => $request->app_paterno,
            'app_materno' => $request->app_materno,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'contrasena' => $request->contrasena,
            'contrasena_confirmation' => $request->contrasena_confirmation,
        ]
    );

    if ($response->successful()) {

        $data = $response->json();

        // 🔥 GUARDAR SESIÓN CORRECTAMENTE
        session([
    'auth_token' => $data['data']['token'],
    'rol' => $data['data']['usuario']['rol'],
    'usuario' => $data['data']['usuario'],
    'nombre' => $data['data']['usuario']['nombre'] ?? $data['data']['usuario']['nombre_completo'],
    'correo' => $data['data']['usuario']['correo']
]);

        return response()->json([
    'message' => 'Cliente registrado correctamente',
    'redirect' => route('home')
]);
    }

    return response()->json([
        'message' => $response->json()['message'] ?? 'Error en registro'
    ], $response->status());

}

public function registerAdmin(Request $request)
{
    $request->validate([
        'contrasena' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/'
        ],
        'correo' => 'required|email',
        'nombre_completo' => 'required',
    ], [
        'contrasena.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.',
        'contrasena.confirmed' => 'Las contraseñas no coinciden.',
    ]);

    $response = Http::withHeaders([
        'Accept' => 'application/json'
    ])->post(
        config('services.api.url') . '/api/register/admin',
        [
            'correo' => $request->correo,
            'contrasena' => $request->contrasena,
            'contrasena_confirmation' => $request->contrasena_confirmation,
            'nombre_completo' => $request->nombre_completo,
            'ciudad' => $request->ciudad,
        ]
    );

    if ($response->successful()) {

    $data = $response->json();

    session([
    'auth_token' => $data['data']['token'],
    'rol' => $data['data']['usuario']['rol'],
    'usuario' => $data['data']['usuario'],
    'nombre' => $data['data']['usuario']['nombre'] ?? $data['data']['usuario']['nombre_completo'],
    'correo' => $data['data']['usuario']['correo']
]);

    return response()->json([
        'message' => 'Administrador registrado correctamente',
        'redirect' => route('business.profile')
    ]);
}
}

}