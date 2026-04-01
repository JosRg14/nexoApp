<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalApi\HttpClient;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Mostrar la página de agendar cita
     */
    public function create(Request $request)
    {
        $negocioId = $request->get('negocio_id');
        
        if (!$negocioId) {
            return redirect()->route('home')
                ->with('error', 'Se requiere un negocio para agendar cita');
        }
        
        Log::info('Booking@create - negocio_id: ' . $negocioId);
        
        // Obtener servicios del negocio
        $servicios = [];
        try {
            $response = $this->httpClient->get('/api/servicios', ['negocio_id' => $negocioId]);
            $servicios = $response['data'] ?? [];
            Log::info('Servicios encontrados: ' . count($servicios));
        } catch (\Exception $e) {
            Log::error('Error al obtener servicios: ' . $e->getMessage());
        }
        
        // Obtener empleados del negocio
        $empleados = [];
        try {
            $response = $this->httpClient->get('/api/empleados', ['negocio_id' => $negocioId]);
            $empleados = $response['data'] ?? [];
            Log::info('Empleados encontrados: ' . count($empleados));
        } catch (\Exception $e) {
            Log::error('Error al obtener empleados: ' . $e->getMessage());
        }
        
        return view('booking.create', compact('servicios', 'empleados', 'negocioId'));
    }
    
    /**
     * Obtener disponibilidad de un empleado (AJAX)
     */
    public function disponibilidad(Request $request, $empleadoId)
    {
        $fecha = $request->get('fecha');
        $duracion = $request->get('duracion', 30);
        
        if (!$fecha) {
            return response()->json(['success' => false, 'message' => 'Fecha requerida'], 400);
        }
        
        try {
            $response = $this->httpClient->get("/api/disponibilidad/empleado/{$empleadoId}", [
                'fecha' => $fecha,
                'duracion' => $duracion
            ]);
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error en disponibilidad: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener disponibilidad'], 500);
        }
    }
    
    /**
     * Crear una nueva cita
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'servicio_id' => 'required|integer',
            'empleado_id' => 'required|integer',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|string',
            'negocio_id' => 'required|integer'
        ]);
        
        try {
            // Verificar si el cliente tiene citas activas primero
            $checkCitas = $this->httpClient->get('/api/clientes/me/citas-activas');
            if (isset($checkCitas['data']['tiene_citas_activas']) && $checkCitas['data']['tiene_citas_activas']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes una cita activa. No puedes agendar otra hasta que sea completada o cancelada.'
                ], 409);
            }

            // Proceder con la creación si no tiene citas activas
            $response = $this->httpClient->post('/api/citas', $validated);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear cita: ' . $e->getMessage());
            
            $statusCode = $e->getCode() && is_numeric($e->getCode()) && $e->getCode() >= 400 && $e->getCode() < 600 
                ? $e->getCode() 
                : 500;
                
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage() ?: 'Error al crear la cita'
            ], $statusCode);
        }
    }
    
    /**
     * Mis citas del cliente
     */
    public function misCitas()
    {
        try {
            $response = $this->httpClient->get('/api/citas/miscitas');
            $citas = $response['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error al obtener citas: ' . $e->getMessage());
            $citas = [];
        }
        
        return view('booking.mis-citas', compact('citas'));
    }

    /**
     * Cancelar cita
     */
    public function cancelarCita(Request $request, $citaId)
    {
        $validated = $request->validate([
            'motivo' => 'nullable|string|max:500',
            'negocio_id' => 'required|integer'
        ]);

        try {
            $data = [
                'negocio_id' => $validated['negocio_id']
            ];
            
            if (!empty($validated['motivo'])) {
                $data['motivo'] = $validated['motivo'];
            }

            // Llamamos a la API con el método PATCH
            $response = $this->httpClient->patch("/api/citas/{$citaId}/cancelar", $data);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error al cancelar cita: ' . $e->getMessage());
            
            $statusCode = $e->getCode() && is_numeric($e->getCode()) && $e->getCode() >= 400 && $e->getCode() < 600 
                ? $e->getCode() 
                : 500;
                
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage() ?: 'Error al cancelar la cita'
            ], $statusCode);
        }
    }
}