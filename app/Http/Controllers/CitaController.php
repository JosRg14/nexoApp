<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalApi\HttpClient;

class CitaController extends Controller
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function create(Request $request)
    {
        try {
            $negocioId = $request->get('negocio_id');
            
            if (!$negocioId) {
                abort(400, 'Se requiere un negocio para agendar cita');
            }
            
            \Log::info('=== CitaController@create ===', ['negocio_id' => $negocioId]);
            
            // Obtener servicios del negocio usando HttpClient
            $servicios = [];
            try {
                $response = $this->httpClient->get('/api/servicios', ['negocio_id' => $negocioId]);
                $servicios = $response['data'] ?? [];
                \Log::info('Servicios obtenidos: ' . count($servicios));
            } catch (\Exception $e) {
                \Log::error('Error al obtener servicios: ' . $e->getMessage());
            }
            
            // Obtener empleados del negocio usando HttpClient
            $empleados = [];
            try {
                $response = $this->httpClient->get('/api/empleados', ['negocio_id' => $negocioId]);
                $empleados = $response['data'] ?? [];
                \Log::info('Empleados obtenidos: ' . count($empleados));
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
        \Log::info('=== WEB: misCitas ===');
        \Log::info('Session usuario:', session('usuario'));
        \Log::info('Session rol:', session('rol'));
        
        $citas = [];
        
        try {
            $response = $this->httpClient->get('/api/citas/miscitas');
            \Log::info('Respuesta API:', $response);
            $citas = $response['data'] ?? [];
            
        } catch (\Exception $e) {
            \Log::error('Error al obtener citas: ' . $e->getMessage());
        }
        
        return view('booking.mis-citas', compact('citas'));
        
    } catch (\Exception $e) {
        \Log::error('Error en CitaController@misCitas: ' . $e->getMessage());
        return view('booking.mis-citas', ['citas' => []]);
    }
}
}