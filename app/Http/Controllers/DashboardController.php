<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\BusinessService;
use Illuminate\Http\Request;
use RuntimeException;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    protected BusinessService $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
        // El middleware se encarga de inyectar el token y validar el rol superusuario
        $this->middleware(['auth.session', 'inject.api.token', 'role:superusuario']);
    }

    /**
     * Dashboard Principal (Estadísticas rápidas)
     */
    public function index()
{
    $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';
    $token = session('auth_token');

    // 1. Petición para el Dashboard (Métricas reales de tu API)
    $dashboardResponse = Http::withToken($token)
        ->withoutVerifying()
        ->get($baseUrl . '/api/admin/dashboard');
    
    // 2. Petición para Actividad Reciente (Limitamos a 5)
    $activityResponse = Http::withToken($token)
        ->withoutVerifying()
        ->get($baseUrl . '/api/admin/actividad-reciente', ['limite' => 5]);

    // Consolidamos los datos
    $metrics = $dashboardResponse->json()['data'] ?? null;
    $activities = $activityResponse->json()['data'] ?? [];

    // NOTA: Si quieres mantener los stats estáticos como respaldo o para otra cosa, 
    // podrías unirlos, pero lo ideal es usar lo que viene de la API.
    
    return view('dashboard.index', [
        'metrics' => $metrics,
        'activities' => $activities
    ]);
}

    /**
     * Listado de Negocios desde NexoApi
     */
    public function businesses(Request $request)
    {
        try {
            // 1. Filtros opcionales (por estado o búsqueda)
            $filters = $request->only(['estado']);
            $response = $this->businessService->list($filters);


            // 2. Mapeamos la respuesta según tu JSON de NexoApi
            $businesses = collect($response['data'] ?? [])->map(function ($item) {
                return [
                    'id'      => $item['id'],
                    'name'    => $item['nombre'],
                    'owner'   => $item['propietario'],
                    'status'  => $item['estado'], // activo, suspendido, pendiente
                    'revenue' => $item['ingresos'] ?? 0,
                    'category' => 'Servicios' // Valor por defecto
                ];
            });

            return view('dashboard.businesses.index', compact('businesses'));

        } catch (RuntimeException $e) {
            // Manejo de errores de conexión o 403 de la API
            return view('dashboard.businesses.index', ['businesses' => []])
                   ->with('api_error', $e->getMessage());
        }
    }

    /**
     * Detalle de un negocio específico
     */
    public function businessDetail($id)
    {
        try {
            // Asumimos que la API tiene /api/admin/negocios/{id}
            // Si no existe el método en el service, habrá que crearlo
            $response = $this->businessService->find($id); 
            $business = $response['data'] ?? null;

            if (!$business) abort(404);

            return view('dashboard.businesses.show', compact('business'));

        } catch (RuntimeException $e) {
            return back()->with('api_error', 'No se pudo obtener el detalle: ' . $e->getMessage());
        }
    }

    public function businessShow($id)
{
    try {
        // Llamamos al servicio para traer un solo negocio
        $response = $this->businessService->find($id);


        dd($response);
        if (!$response['success']) {
            return redirect()->route('dashboard.businesses')->with('api_error', 'Negocio no encontrado');
        }

        $business = $response['data'];

        return view('dashboard.businesses.show', compact('business'));

    } catch (\Exception $e) {
        return redirect()->route('dashboard.businesses')->with('api_error', 'Error al conectar con la API');
    }
}

// Método para el botón de Suspender/Activar
public function updateStatus(Request $request, $id)
{
    try {
        // Enviamos a la API el nuevo estado (ej: 'suspendido' o 'activo')
        $this->businessService->updateStatus($id, $request->status);

        return back()->with('success', 'Estado actualizado correctamente');
    } catch (\Exception $e) {
        return back()->with('api_error', 'No se pudo cambiar el estado');
    }
}

public function updateBusinessStatus(Request $request, $id)
{
    // Validamos que el estado sea uno de los permitidos por tu tabla
    $validated = $request->validate([
        'estado' => 'required|in:activo,suspendido,pendiente'
    ]);

    $response = $this->businessService->updateStatus($id, $validated['estado']);

    if (isset($response['success']) && $response['success']) {
        
        return redirect()->back()->with('status', 'El estado del negocio se actualizó a: ' . $validated['estado']);
    }

    return redirect()->back()->with('error', 'No se pudo actualizar el estado en el servidor externo.');
}

    public function promotions()
    {
        return view('dashboard.promotions.index');
    }

    public function notices()
    {
        return view('dashboard.notices.index');
    }

    public function storeNotice(Request $request)
{
    $token = session('auth_token');
    $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

    // Enviamos el aviso masivo
    $response = Http::withToken($token)
        ->withoutVerifying()
        ->post($baseUrl . '/api/admin/avisos/masivos', [
            'asunto'        => $request->asunto,
            'mensaje'       => $request->mensaje,
            'destinatarios' => $request->destinatarios // "todos", "activos" o "suspendidos"
        ]);

    if ($response->successful()) {
        return back()->with('success', '¡Aviso enviado con éxito!');
    }

    return back()->withErrors(['api' => 'Hubo un problema al enviar el aviso: ' . $response->json()['message']]);
}
}


