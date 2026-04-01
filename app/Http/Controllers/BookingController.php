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
            $response = $this->httpClient->post('/api/citas', $validated);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear cita: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear la cita'], 500);
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
}