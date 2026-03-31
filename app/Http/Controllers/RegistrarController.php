<?php

namespace App\Http\Controllers; // <--- Revisa que esto esté escrito así

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegistrarController extends Controller
{
    protected $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host/api';

    /**
     * PASO 1: Mostrar el formulario de registro de usuario (Tu captura 2)
     */
    public function showRegistroUsuario()
    {
        return view('auth.register');
    }

    /**
     * PASO 1.2: Procesar la creación de la cuenta
     */
    public function storeUsuario(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'name' => 'required',
            'ciudad' => 'required',
        ]);

        try {
            $response = Http::withoutVerifying()->post($this->baseUrl.'/register', $request->all());

            if ($response->successful()) {
                // Guardamos el token en sesión para el siguiente paso
                session(['auth_token' => $response->json()['token']]);

                // REDIRIGIMOS AL APARTADO 1.5
                return redirect()->route('registro.negocio.paso2');
            }

            return back()->withErrors(['error' => 'No se pudo crear la cuenta.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor.']);
        }
    }

    /**
     * PASO 1.5: Mostrar selección de Plan y Datos del Negocio (Onboarding)
     */
    public function showRegistroNegocio()
    {
        $token = session('auth_token');

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($token)
                ->withoutVerifying()
                ->get($this->baseUrl.'/planes');

            // IMPORTANTE: Verifica que la API devuelva 'data'
            $planes = $response->json()['data'] ?? [];

            return view('business.profile.onboarding-negocio', compact('planes'));
        } catch (\Exception $e) {
            return view('business.profile.onboarding-negocio', ['planes' => []]);
        }
    }

    public function storeNegocio(Request $request)
{
    $token = session('auth_token');

    // 1. Validación en el Front
    $request->validate([
        'nombre' => 'required',
        'tipo_negocio' => 'required',
        'plan_id' => 'required',
    ]);

    try {
        // 2. Mapeo EXACTO según tu tabla de API
        $datosParaApi = [
            'nombre_negocio' => $request->nombre, // La API pide nombre_negocio
            'tipo_negocio'   => $request->tipo_negocio,
            'suscripcion_id' => $request->plan_id, // La API pide suscripcion_id
            
            // OJO: Tu API pide estos campos como OBLIGATORIOS (✅) según tu tabla:
            'telefono'       => '0000000000', // Agrega estos campos o recógelos en el form
            'calle'          => 'Pendiente',
            'numero'         => '0',
            'colonia'        => 'Pendiente',
            'ciudad'         => 'Pendiente',
            'estado'         => 'Pendiente',
            'codigo_postal'  => '00000',
        ];

        // 3. Petición POST
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->asMultipart() // Tu doc dice usar multipart/form-data
            ->post($this->baseUrl.'/negocio/completar', $datosParaApi);

        if ($response->successful()) {
            return redirect()->route('business.profile')
                ->with('success', 'Negocio registrado exitosamente');
        }

        // Si hay error (como el 302 o 422)
        return back()->withInput()->with('error', 'La API rechazó el registro. Revisa los datos.');

    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Error de conexión: ' . $e->getMessage());
    }
}

// Dentro de RegistrarController.php

public function showEsperandoValidacion()
{
    $token = session('auth_token');

    try {
        $response = \Illuminate\Support\Facades\Http::withToken($token)
            ->withoutVerifying()
            ->get($this->baseUrl . '/mi-suscripcion');

        $data = $response->json()['data'] ?? null;

        $suscripcion = [
            'negocio_nombre' => $data['nombre'] ?? 'Tu Negocio',
            'plan_nombre'    => $data['plan'] ?? 'Seleccionado'
        ];

        return view('business.profile.waiting-validation', compact('suscripcion'));
        
    } catch (\Exception $e) {
        return view('business.profile.waiting-validation', ['suscripcion' => null]);
    }
}
}
