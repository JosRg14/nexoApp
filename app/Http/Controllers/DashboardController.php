<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\BusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RuntimeException;

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
            ->get($baseUrl.'/api/admin/dashboard');

        // 2. Petición para Actividad Reciente (Limitamos a 5)
        $activityResponse = Http::withToken($token)
            ->withoutVerifying()
            ->get($baseUrl.'/api/admin/actividad-reciente', ['limite' => 5]);

        // Consolidamos los datos
        $metrics = $dashboardResponse->json()['data'] ?? null;
        $activities = $activityResponse->json()['data'] ?? [];

        // NOTA: Si quieres mantener los stats estáticos como respaldo o para otra cosa,
        // podrías unirlos, pero lo ideal es usar lo que viene de la API.

        return view('dashboard.index', [
            'metrics' => $metrics,
            'activities' => $activities,
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
                    'id' => $item['id'],
                    'name' => $item['nombre'],
                    'owner' => $item['propietario'],
                    'status' => $item['estado'], // activo, suspendido, pendiente
                    'revenue' => $item['ingresos'] ?? 0,
                    'category' => 'Servicios', // Valor por defecto
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

            if (! $business) {
                abort(404);
            }

            return view('dashboard.businesses.show', compact('business'));

        } catch (RuntimeException $e) {
            return back()->with('api_error', 'No se pudo obtener el detalle: '.$e->getMessage());
        }
    }

    public function businessShow($id)
    {
        try {
            // Llamamos al servicio para traer un solo negocio
            $response = $this->businessService->find($id);

            dd($response);
            if (! $response['success']) {
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
            'estado' => 'required|in:activo,suspendido,pendiente',
        ]);

        $response = $this->businessService->updateStatus($id, $validated['estado']);

        if (isset($response['success']) && $response['success']) {

            return redirect()->back()->with('status', 'El estado del negocio se actualizó a: '.$validated['estado']);
        }

        return redirect()->back()->with('error', 'No se pudo actualizar el estado en el servidor externo.');
    }

    public function promotions()
    {
        return view('dashboard.promotions.index');
    }

    public function notices()
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // 1. Pedimos el historial a la API
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->get($baseUrl.'/api/admin/avisos/historial');

        // 2. Extraemos los datos (si falla, enviamos un array vacío)
        $avisos = $response->successful() ? $response->json()['data'] : [];

        // 3. Pasamos los avisos a la vista
        return view('dashboard.notices.index', compact('avisos'));
    }

    public function storeNotice(Request $request)
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // Enviamos el aviso masivo
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->post($baseUrl.'/api/admin/avisos/masivos', [
                'asunto' => $request->asunto,
                'mensaje' => $request->mensaje,
                'destinatarios' => $request->destinatarios, // "todos", "activos" o "suspendidos"
            ]);

        if ($response->successful()) {
            return back()->with('success', '¡Aviso enviado con éxito!');
        }

        return back()->withErrors(['api' => 'Hubo un problema al enviar el aviso: '.$response->json()['message']]);
    }

    /**
     * Listado de Planes de Suscripción (GET /api/admin/planes)
     */
    public function planes()
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // 1. Pedimos los planes actuales a la API
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->get($baseUrl.'/api/admin/planes');

        // 2. Extraemos los datos (si falla, enviamos un array vacío para no romper el Blade)
        $planes = $response->successful() ? $response->json()['data'] : [];

        // 3. Retornamos la vista que acabamos de diseñar
        return view('dashboard.promotions.index', compact('planes'));
    }

    /**
     * Crear un nuevo Plan en la API (POST /api/admin/planes)
     */
    public function storePlan(Request $request)
{
    $token = session('auth_token');
    $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

    // 1. Validamos que el front envíe los datos mínimos
    $request->validate([
        'tipo' => 'required',
        'costo' => 'required',
        'duracion_meses' => 'required|integer',
    ]);

    // 2. Construimos el JSON exacto que tu API espera
    $response = Http::withToken($token)
        ->withoutVerifying()
        ->post($baseUrl . '/api/admin/planes', [
            'tipo'              => $request->tipo,
            'duracion'          => $request->duracion_meses . " meses", // LA API PIDE ESTO
            'descripcion'       => $request->descripcion ?? 'Sin descripción',
            'costo'             => (float)$request->costo,
            'duracion_meses'    => (int)$request->duracion_meses,
            'nivel_visibilidad' => (int)$request->nivel_visibilidad,
        ]);

    if ($response->successful()) {
        return back()->with('success', 'Plan creado correctamente');
    }

    // Si falla, vamos a ver qué dice la API exactamente
    return back()->withErrors(['api' => 'Error ' . $response->status() . ': ' . $response->body()]);
}

    public function pendingSubscriptions()
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        $response = Http::withToken($token)
            ->withoutVerifying()
            ->get($baseUrl.'/api/admin/suscripciones/pendientes');

        $pendientes = $response->successful() ? $response->json()['data'] : [];

        return view('dashboard.subscriptions.index', compact('pendientes'));
    }

    
}
