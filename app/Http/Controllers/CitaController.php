<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CitaController extends Controller
{
    public function create(Request $request)
    {
        $negocioId = $request->get('negocio_id');
        $servicioId = $request->get('servicio');
        $empleadoId = $request->get('empleado');
        
        $apiBaseUrl = config('services.api.url');
        
        // Obtener servicios del negocio
        $servicios = [];
        try {
            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->get($apiBaseUrl . '/api/servicios', [
                    'negocio_id' => $negocioId
                ]);
            if ($response->successful()) {
                $servicios = $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            \Log::error('Error al obtener servicios: ' . $e->getMessage());
        }
        
        // Obtener empleados del negocio
        $empleados = [];
        try {
            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->get($apiBaseUrl . '/api/empleados', [
                    'negocio_id' => $negocioId
                ]);
            if ($response->successful()) {
                $empleados = $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            \Log::error('Error al obtener empleados: ' . $e->getMessage());
        }
        
        return view('booking.create', compact('servicios', 'empleados', 'negocioId', 'servicioId', 'empleadoId'));
    }
    
    public function misCitas()
    {
        $token = session('auth_token');
        $apiBaseUrl = config('services.api.url');
        
        $citas = [];
        try {
            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get($apiBaseUrl . '/api/citas/mis-citas');
            
            if ($response->successful()) {
                $citas = $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            \Log::error('Error al obtener citas: ' . $e->getMessage());
        }
        
        return view('booking.mis-citas', compact('citas'));
    }
}