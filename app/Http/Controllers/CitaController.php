<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalApi\HttpClient;
use Illuminate\Support\Facades\Log;

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
                return redirect()->route('home')
                    ->with('error', 'Se requiere un negocio para agendar cita');
            }
            
            Log::info('=== CitaController@create ===', ['negocio_id' => $negocioId]);
            
            // Obtener servicios del negocio usando HttpClient
            $servicios = [];
            try {
                $response = $this->httpClient->get('/api/servicios', ['negocio_id' => $negocioId]);
                
                if (isset($response['success']) && $response['success']) {
                    $servicios = $response['data'] ?? [];
                    Log::info('Servicios obtenidos: ' . count($servicios));
                } else {
                    Log::warning('API devolvió error en servicios', ['response' => $response]);
                }
            } catch (\Exception $e) {
                Log::error('Error al obtener servicios: ' . $e->getMessage());
            }
            
            // Obtener empleados del negocio usando HttpClient
            $empleados = [];
            try {
                $response = $this->httpClient->get('/api/empleados', ['negocio_id' => $negocioId]);
                
                if (isset($response['success']) && $response['success']) {
                    $empleados = $response['data'] ?? [];
                    Log::info('Empleados obtenidos: ' . count($empleados));
                } else {
                    Log::warning('API devolvió error en empleados', ['response' => $response]);
                }
            } catch (\Exception $e) {
                Log::error('Error al obtener empleados: ' . $e->getMessage());
            }
            
            // Verificar que hay servicios y empleados
            if (empty($servicios)) {
                Log::warning('No hay servicios para el negocio', ['negocio_id' => $negocioId]);
            }
            
            if (empty($empleados)) {
                Log::warning('No hay empleados para el negocio', ['negocio_id' => $negocioId]);
            }
            
            return view('booking.create', compact('servicios', 'empleados', 'negocioId'));
            
        } catch (\Exception $e) {
            Log::error('Error en CitaController@create: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->route('home')
                ->with('error', 'Error al cargar la página de reserva: ' . $e->getMessage());
        }
    }
    
    public function misCitas()
    {
        try {
            Log::info('=== WEB: misCitas ===');
            
            $usuario = session('usuario');
            $rol = session('rol');
            
            Log::info('Session usuario:', ['usuario' => $usuario, 'rol' => $rol]);
            
            $citas = [];
            
            try {
                $response = $this->httpClient->get('/api/citas/miscitas');
               
                Log::info('Respuesta API mis citas:', ['response' => $response]);
                
                if (isset($response['success']) && $response['success']) {
                    $citas = $response['data'] ?? [];
                } else {
                    Log::warning('API devolvió error en mis citas', ['response' => $response]);
                }
                
            } catch (\Exception $e) {
                Log::error('Error al obtener citas: ' . $e->getMessage());
            }
            
            return view('booking.mis-citas', compact('citas'));
            
        } catch (\Exception $e) {
            Log::error('Error en CitaController@misCitas: ' . $e->getMessage());
            return view('booking.mis-citas', ['citas' => []])
                ->with('error', 'Error al cargar tus citas');
        }
    }
    
    /**
     * Obtener disponibilidad de un empleado (para AJAX)
     */
    public function disponibilidadEmpleado($id, Request $request)
    {
        try {
            $fecha = $request->get('fecha');
            $duracion = $request->get('duracion', 30);
            
            if (!$fecha) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fecha requerida'
                ], 400);
            }
            
            Log::info('=== Disponibilidad Empleado ===', [
                'empleado_id' => $id,
                'fecha' => $fecha,
                'duracion' => $duracion
            ]);
            
            $response = $this->httpClient->get('/api/disponibilidad/empleado/' . $id, [
                'fecha' => $fecha,
                'duracion' => $duracion
            ]);
            
            Log::info('Respuesta disponibilidad:', $response);
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Error en disponibilidadEmpleado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener disponibilidad',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Crear una cita (proxy)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'servicio_id' => 'required|integer',
                'empleado_id' => 'required|integer',
                'fecha' => 'required|date|after_or_equal:today',
                'hora_inicio' => 'required|string',
                'negocio_id' => 'required|integer'
            ]);
            
            Log::info('=== Creando cita ===', $validated);
            
            $response = $this->httpClient->post('/api/citas', $validated);
            
            Log::info('Respuesta creación cita:', $response);
            
            return response()->json($response, 201);
            
        } catch (\Exception $e) {
            Log::error('Error al crear cita: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cita: ' . $e->getMessage()
            ], 500);
        }
    }
}