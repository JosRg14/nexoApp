<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CitaController extends Controller
{
    public function create(Request $request)
    {
        try {
            $negocioId = $request->get('negocio_id');
            
            if (!$negocioId) {
                abort(400, 'Se requiere un negocio para agendar cita');
            }
            
            \Log::info('=== CitaController@create ===', ['negocio_id' => $negocioId]);
            
            // Usar el proxy público correctamente
            $proxyBaseUrl = url('/api-proxy/public');
            
            // Obtener servicios del negocio
            $servicios = [];
            try {
                // Log de la URL que se va a llamar
                $url = $proxyBaseUrl . '/servicios';
                \Log::info('Llamando a proxy para servicios: ' . $url . '?negocio_id=' . $negocioId);
                
                $response = Http::timeout(15)
                    ->withOptions(['verify' => false])
                    ->get($url, [
                        'negocio_id' => $negocioId
                    ]);
                
                \Log::info('Respuesta servicios - Status: ' . $response->status());
                \Log::info('Respuesta servicios - Body: ' . substr($response->body(), 0, 500));
                
                if ($response->successful()) {
                    $data = $response->json();
                    $servicios = $data['data'] ?? [];
                    \Log::info('Servicios obtenidos: ' . count($servicios));
                }
            } catch (\Exception $e) {
                \Log::error('Error al obtener servicios: ' . $e->getMessage());
            }
            
            // Obtener empleados del negocio
            $empleados = [];
            try {
                $url = $proxyBaseUrl . '/empleados';
                \Log::info('Llamando a proxy para empleados: ' . $url . '?negocio_id=' . $negocioId);
                
                $response = Http::timeout(15)
                    ->withOptions(['verify' => false])
                    ->get($url, [
                        'negocio_id' => $negocioId
                    ]);
                
                \Log::info('Respuesta empleados - Status: ' . $response->status());
                \Log::info('Respuesta empleados - Body: ' . substr($response->body(), 0, 500));
                
                if ($response->successful()) {
                    $data = $response->json();
                    $empleados = $data['data'] ?? [];
                    \Log::info('Empleados obtenidos: ' . count($empleados));
                }
            } catch (\Exception $e) {
                \Log::error('Error al obtener empleados: ' . $e->getMessage());
            }
            
            return view('booking.create', compact('servicios', 'empleados', 'negocioId'));
            
        } catch (\Exception $e) {
            \Log::error('Error en CitaController@create: ' . $e->getMessage());
            abort(500, 'Error al cargar la página de reserva: ' . $e->getMessage());
        }
    }
    
    public function misCitas()
    {
        try {
            $token = session('auth_token');
            $apiBaseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';
            
            $citas = [];
            try {
                $response = Http::timeout(15)
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