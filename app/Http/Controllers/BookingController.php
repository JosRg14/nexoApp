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

        // Obtener ID de cliente de la sesión
        $usuario = session('usuario');
        $clienteId = null;
        if (isset($usuario['rol']) && $usuario['rol'] === 'cliente') {
            $clienteId = $usuario['cliente']['id_cliente'] ?? $usuario['id'] ?? null;
        }
        
        return view('booking.create', compact('servicios', 'empleados', 'negocioId', 'clienteId'));
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
            'negocio_id' => 'required|integer',
            'id_promocion_cliente' => 'nullable|integer'
        ]);
        
        try {
            // Preparar el payload filtrando valores null para evitar problemas con la API si no los espera
            $payload = array_filter($validated, fn($value) => !is_null($value));
            
            // Verificar si el cliente tiene citas activas primero
            $checkCitas = $this->httpClient->get('/api/clientes/me/citas-activas');
            if (isset($checkCitas['data']['tiene_citas_activas']) && $checkCitas['data']['tiene_citas_activas']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes una cita activa. No puedes agendar otra hasta que sea completada o cancelada.'
                ], 409);
            }

            // Proceder con la creación si no tiene citas activas
            $response = $this->httpClient->post('/api/citas', $payload);
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
            // Si el token no es válido o expiró, redirigir al login
            if ($e->getCode() === 401 || $e->getMessage() === 'UNAUTHORIZED_API_TOKEN') {
                Log::warning('BookingController@misCitas: Sesión de API expirada. Redirigiendo a login.');
                
                // Limpiar sesión local
                session()->flush();
                
                return redirect()->route('login')->with('error', 'Tu sesión ha expirado, por favor inicia sesión nuevamente');
            }

            Log::error('Error al obtener citas en misCitas: ' . $e->getMessage());
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
            'negocio_id' => 'nullable|integer'
        ]);

        $negocioId = $validated['negocio_id'] ?? null;

        // Si no se proporcionó negocio_id desde el frontend, intentamos recuperar la cita de la API externa para extraerlo
        if (!$negocioId) {
            try {
                $citaResponse = $this->httpClient->get("/api/citas/{$citaId}");
                $negocioId = $citaResponse['data']['negocio_id'] ?? $citaResponse['data']['negocio']['id'] ?? null;
            } catch (\Exception $e) {
                Log::warning('BookingController@cancelarCita - No se pudo pre-cargar la cita para obtener su negocio_id: ' . $e->getMessage());
            }
        }

        Log::info('BookingController@cancelarCita - payload info', [
            'cita_id' => $citaId,
            'negocio_id_enviado' => $negocioId,
            'motivo_enviado' => $validated['motivo'] ?? 'ninguno'
        ]);

        if (!$negocioId) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener el ID del negocio correspondiente para cancelar la cita.'
            ], 400);
        }

        try {
            $data = [
                'negocio_id' => $negocioId
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

    /**
     * Crear reseña
     */
    public function crearResena(Request $request, $citaId)
    {
        try {
            $response = $this->httpClient->post("/api/citas/{$citaId}/resena", [
                'calificacion' => $request->calificacion,
                'comentario' => $request->comentario
            ]);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error al crear reseña: ' . $e->getMessage());
            $statusCode = $e->getCode() && is_numeric($e->getCode()) && $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            return response()->json(['success' => false, 'message' => 'Error al crear la reseña: ' . $e->getMessage()], $statusCode);
        }
    }

    /**
     * Editar reseña
     */
    public function editarResena(Request $request, $resenaId)
    {
        try {
            $response = $this->httpClient->put("/api/resenas/cita/{$resenaId}", [
                'calificacion' => $request->calificacion,
                'comentario' => $request->comentario
            ]);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error al editar reseña: ' . $e->getMessage());
            $statusCode = $e->getCode() && is_numeric($e->getCode()) && $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            return response()->json(['success' => false, 'message' => 'Error al editar la reseña: ' . $e->getMessage()], $statusCode);
        }
    }

    /**
     * Eliminar reseña
     */
    public function eliminarResena($resenaId)
    {
        try {
            $response = $this->httpClient->delete("/api/resenas/cita/{$resenaId}");
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error al eliminar reseña: ' . $e->getMessage());
            $statusCode = $e->getCode() && is_numeric($e->getCode()) && $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            return response()->json(['success' => false, 'message' => 'Error al eliminar la reseña: ' . $e->getMessage()], $statusCode);
        }
    }
}