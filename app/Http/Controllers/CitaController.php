<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CitaController extends Controller
{
    public function create(Request $request)
    {
        try {
            \Log::info('=== CitaController@create ===');
            
            $negocioId = $request->get('negocio_id');
            $servicioId = $request->get('servicio');
            $empleadoId = $request->get('empleado');
            
            \Log::info('Parámetros recibidos:', [
                'negocio_id' => $negocioId,
                'servicio' => $servicioId,
                'empleado' => $empleadoId
            ]);
            
            // Usar el proxy local para evitar problemas de CORS
            $proxyBaseUrl = url('/api-proxy');
            
            // Obtener servicios del negocio
            $servicios = [];
            try {
                $response = Http::timeout(10)
                    ->withOptions(['verify' => false])
                    ->get($proxyBaseUrl . '/servicios', [
                        'negocio_id' => $negocioId
                    ]);
                
                \Log::info('Respuesta servicios - Status: ' . $response->status());
                
                if ($response->successful()) {
                    $servicios = $response->json('data') ?? [];
                    \Log::info('Servicios obtenidos: ' . count($servicios));
                } else {
                    \Log::warning('Error al obtener servicios: ' . $response->body());
                }
            } catch (\Exception $e) {
                \Log::error('Error al obtener servicios: ' . $e->getMessage());
            }
            
            // Obtener empleados del negocio
            $empleados = [];
            try {
                $response = Http::timeout(10)
                    ->withOptions(['verify' => false])
                    ->get($proxyBaseUrl . '/empleados', [
                        'negocio_id' => $negocioId
                    ]);
                
                \Log::info('Respuesta empleados - Status: ' . $response->status());
                
                if ($response->successful()) {
                    $empleados = $response->json('data') ?? [];
                    \Log::info('Empleados obtenidos: ' . count($empleados));
                } else {
                    \Log::warning('Error al obtener empleados: ' . $response->body());
                }
            } catch (\Exception $e) {
                \Log::error('Error al obtener empleados: ' . $e->getMessage());
            }
            
            return view('booking.create', compact('servicios', 'empleados', 'negocioId', 'servicioId', 'empleadoId'));
            
        } catch (\Exception $e) {
            \Log::error('Error en CitaController@create: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            abort(500, 'Error al cargar la página de reserva: ' . $e->getMessage());
        }
    }
    
    public function misCitas()
    {
        try {
            $token = session('auth_token');
            $apiBaseUrl = rtrim(config('services.api.url'), '/');
            
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
            
        } catch (\Exception $e) {
            \Log::error('Error en CitaController@misCitas: ' . $e->getMessage());
            abort(500, 'Error al cargar tus citas');
        }
    }
}