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

    if ($response->successful()) {
        return response()->json($response->json());
    }

    return response()->json([
        'message' => 'Credenciales incorrectas'
    ], 401);
}
}