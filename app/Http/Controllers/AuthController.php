<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    

//VISTAS

public function showLogin()
{
    return view('auth.login');
}

public function showRoleSelection()
{
    return view('auth.role-selection');
}

public function showBusinessRegister()
{
    return view('auth.register-business');
}

public function showClientRegister()
{
    return view('auth.register-client');
}

    public function login(Request $request)
{
    \Log::info('=== LOGIN NORMAL ===');
    \Log::info('Correo:', ['correo' => $request->email]);
    
    $headers = [
        'Accept' => 'application/json',
        'ngrok-skip-browser-warning' => 'true',
        'User-Agent' => 'Mozilla/5.0',
    ];

    $response = Http::withHeaders($headers)
        ->timeout(15)
        ->retry(2, 500)
        ->post(config('services.api.url') . '/api/login', [
            'correo' => $request->email,
            'contrasena' => $request->password,
        ]);

    \Log::info('API Response:', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);

    if (!$response->successful()) {
        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $data = $response->json();

    if (!isset($data['data']['token']) || !isset($data['data']['rol'])) {
        return response()->json([
            'message' => 'Respuesta inesperada del servidor'
        ], 500);
    }

    $usuario = $this->formatUserData($data['data']['usuario']);

    \Log::info('Datos a guardar en sesión:', [
        'token' => $data['data']['token'],
        'rol' => $data['data']['rol'],
        'usuario' => $usuario,
        'negocio' => $data['data']['usuario']['negocio'] ?? null
    ]);

    session([
        'auth_token' => $data['data']['token'],
        'rol' => $data['data']['rol'],
        'usuario' => $usuario,
        'negocio' => $data['data']['usuario']['negocio'] ?? null
    ]);

    \Log::info('Sesión después de guardar:', [
        'session_token' => session('auth_token'),
        'session_rol' => session('rol'),
        'session_usuario' => session('usuario')
    ]);

    return response()->json([
        'redirect' => match ($data['data']['rol']) {
            'superusuario' => route('dashboard.index'),
            'admin' => route('business.profile'),
            'cliente' => route('booking.mis-citas'),
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
            $usuario = $this->formatUserData($data['data']['usuario']);

            session([
                'auth_token' => $data['data']['token'],
                'rol' => $usuario['rol'],
                'usuario' => $usuario,
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
            $usuario = $this->formatUserData($data['data']['usuario']);

            session([
                'auth_token' => $data['data']['token'],
                'rol' => $usuario['rol'],
                'usuario' => $usuario,
            ]);

            return response()->json([
                'message' => 'Administrador registrado correctamente',
                'redirect' => route('business.profile')
            ]);
        }
    }

    /**
     * Helper to format user data and ensure common fields exist.
     */
    protected function formatUserData(array $usuario): array
    {
        // Construct full name if missing
        if (!isset($usuario['nombre_completo'])) {
            $nombre = $usuario['nombre'] ?? '';
            $paterno = $usuario['app_paterno'] ?? $usuario['apellido_paterno'] ?? '';
            $materno = $usuario['app_materno'] ?? $usuario['apellido_materno'] ?? '';
            
            $fullName = trim("$nombre $paterno $materno");
            
            $usuario['nombre_completo'] = !empty($fullName) ? $fullName : ($usuario['correo'] ?? 'Usuario');
        }

        // Extract first name
        $parts = explode(' ', $usuario['nombre_completo']);
        $usuario['primer_nombre'] = $parts[0] ?? ($usuario['correo'] ?? 'Usuario');

        return $usuario;
    }

    public function logout()
    {
        $token = session('auth_token');

        if ($token) {
            try {
                Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])->post(config('services.api.url') . '/api/logout');
            } catch (\Exception $e) {
                logger("Error al cerrar sesión en API: " . $e->getMessage());
            }
        }

        session()->flush();

        return redirect('/')->with('message', 'Sesión cerrada correctamente');
    }

    public function redirectToGoogle(Request $request)
    {
        $rol = $request->query('rol', 'cliente');
        if (!in_array($rol, ['admin', 'cliente'])) {
            $rol = 'cliente';
        }

        return redirect(config('services.api.url') . '/auth/google?rol=' . $rol);
    }


    public function googleCallback(Request $request)
{
    \Log::info('=== GOOGLE CALLBACK WEB ===');
    \Log::info('Code:', ['code' => $request->code]);
    \Log::info('State:', ['state' => $request->state]);
    
    $response = Http::withHeaders(['Accept' => 'application/json'])
        ->get(config('services.api.url') . '/auth/google/callback', [
            'code' => $request->code,
            'state' => $request->state,
        ]);

    \Log::info('API Response Status:', ['status' => $response->status()]);
    \Log::info('API Response Body:', ['body' => $response->body()]);

    if ($response->successful()) {
        $resData = $response->json();
        $data = $resData['data'];
        
        \Log::info('Data recibido:', ['data' => $data]);

        session([
            'auth_token' => $data['token'],
            'rol'        => $data['usuario']['rol'],
            'usuario'    => $data['usuario'],
        ]);

        \Log::info('Sesión guardada:', [
            'token' => session('auth_token'),
            'rol' => session('rol'),
            'usuario' => session('usuario')
        ]);

        $rol = $data['usuario']['rol'];
        
        if ($rol === 'admin') {      
            \Log::info('Admin autenticado, redirigiendo a business.profile');
            return redirect()->route('business.profile');
        } elseif ($rol === 'cliente') {
            \Log::info('Cliente autenticado, redirigiendo a mis citas');
            return redirect()->route('booking.mis-citas');
        }
        
        return redirect('/');
    }

    \Log::error('Error en callback Google:', ['response' => $response->body()]);
    return redirect('/login')->with('error', 'Error al sincronizar con Google');
}

}