<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\BusinessService;
use Illuminate\Http\Request;
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
            // 1. Obtenemos los filtros de la URL (ej: ?estado=pendiente)
            $filters = $request->only(['estado']);

            // 2. Pedimos a la API los negocios filtrados para la tabla
            $response = $this->businessService->list($filters);

            // 3. Mapeamos la respuesta para la tabla
            $businesses = collect($response['data'] ?? [])->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['nombre'],
                    'owner' => $item['propietario'],
                    'status' => $item['estado'], // activo, suspendido, pendiente
                    'revenue' => $item['ingresos'] ?? 0,
                    'category' => 'Servicios',
                ];
            });

            // 4. Calculamos el contador de PENDIENTES total
            // Si tu API permite traer todo, lo ideal es contar sobre la lista completa
            // para que el badge siempre muestre el número real, no solo el del filtro actual.
            $fullListResponse = $this->businessService->list();
            $countPendientes = collect($fullListResponse['data'] ?? [])
                ->where('estado', 'pendiente')
                ->count();

            // 5. Retornamos la vista con AMBAS variables
            return view('dashboard.businesses.index', compact('businesses', 'countPendientes'));

        } catch (\RuntimeException $e) {
            return view('dashboard.businesses.index', [
                'businesses' => [],
                'countPendientes' => 0,
            ])->with('api_error', $e->getMessage());
        } catch (\Exception $e) {
            return view('dashboard.businesses.index', [
                'businesses' => [],
                'countPendientes' => 0,
            ])->with('api_error', 'Error inesperado al cargar negocios.');
        }
    }

    /**
     * Detalle de un negocio específico
     */
    public function businessDetail($id)
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // 1. Obtener datos básicos del negocio
        $response = Http::withToken($token)->withoutVerifying()
            ->get($baseUrl."/api/admin/negocios/{$id}");

        $business = $response->json()['data'] ?? null;

        if (! $business) {
            return redirect()->route('dashboard.businesses')->with('api_error', 'Negocio no encontrado');
        }

        // 2. Obtener historial de suscripciones del negocio
        try {
            $subResponse = Http::withToken($token)->withoutVerifying()
                ->get($baseUrl."/api/admin/negocios/{$id}/suscripciones");

            $subscriptions = $subResponse->json()['data'] ?? [];
        } catch (\Exception $e) {
            $subscriptions = [];
        }

        // 3. Obtener la lista de planes disponibles (para el select de "Nuevo Plan")
        try {
            // Esta petición suele ser pública o requiere el mismo token
            $planesResponse = Http::withoutVerifying()
                ->get($baseUrl.'/api/planes');

            $planesDisponibles = $planesResponse->json()['data'] ?? [];
        } catch (\Exception $e) {
            $planesDisponibles = [];
        }

        // 4. Retornar la vista con todas las variables necesarias
        return view('dashboard.businesses.show', [
            'business' => $business,
            'subscriptions' => $subscriptions,
            'planesDisponibles' => $planesDisponibles, // Agregamos esta para el select dinámico
        ]);
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
    /**
     * Método único y corregido para suspender/activar negocios
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Validamos lo que llega del formulario (campo 'estado')
        $validated = $request->validate([
            'estado' => 'required|in:activo,suspendido,pendiente',
        ]);

        try {
            // 2. Usamos el valor validado para la API
            $response = $this->businessService->updateStatus($id, $validated['estado']);

            // 3. Verificamos si la API respondió con éxito
            if (isset($response['success']) && $response['success']) {
                return back()->with('success', 'El estado se actualizó a: '.$validated['estado']);
            }

            return back()->with('api_error', 'La API externa no pudo procesar el cambio.');

        } catch (\Exception $e) {
            return back()->with('api_error', 'Error de comunicación: '.$e->getMessage());
        }
    }

    public function promotions()
    {
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // 1. Consumimos la API pública de planes
        $response = \Illuminate\Support\Facades\Http::withoutVerifying()
            ->get($baseUrl.'/api/planes');

        // 2. Extraemos los datos (si falla, enviamos array vacío)
        $planes = $response->successful() ? $response->json()['data'] : [];

        // 3. PASAMOS LA VARIABLE A LA VISTA (Aquí estaba el error)
        return view('dashboard.promotions.index', compact('planes'));
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
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // 1. Usamos la ruta pública /api/planes (sin withToken)
        $response = Http::withoutVerifying()
            ->get($baseUrl.'/api/planes');

        // 2. Extraemos los datos
        $planes = $response->successful() ? $response->json()['data'] : [];

        // 3. Retornamos la misma vista
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
            ->post($baseUrl.'/api/admin/planes', [
                'tipo' => $request->tipo,
                'duracion' => $request->duracion_meses.' meses', // LA API PIDE ESTO
                'descripcion' => $request->descripcion ?? 'Sin descripción',
                'costo' => (float) $request->costo,
                'duracion_meses' => (int) $request->duracion_meses,
                'nivel_visibilidad' => (int) $request->nivel_visibilidad,
            ]);

        if ($response->successful()) {
            return back()->with('success', 'Plan creado correctamente');
        }

        // Si falla, vamos a ver qué dice la API exactamente
        return back()->withErrors(['api' => 'Error '.$response->status().': '.$response->body()]);
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

    public function updatePlan(Request $request, $id)
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // Solo enviamos lo que viene en el request (la API dice: "Solo enviar campos a modificar")
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->put($baseUrl."/api/admin/planes/{$id}", $request->except(['_token', '_method']));

        if ($response->successful()) {
            return back()->with('success', 'Plan actualizado correctamente');
        }

        return back()->withErrors(['api' => 'No se pudo actualizar el plan']);
    }

    public function destroyPlan($id)
    {
        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        // 1. Ejecutamos la petición DELETE a la API
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->delete($baseUrl."/api/admin/planes/{$id}");

        $data = $response->json();

        // 2. Si la API responde con éxito
        if ($response->successful() && ($data['success'] ?? false)) {
            return back()->with('success', 'Plan eliminado correctamente');
        }

        // 3. Si falla (por ejemplo, el error 400 de negocios activos)
        $errorMsg = $data['message'] ?? 'No se pudo eliminar el plan';

        return back()->withErrors(['api' => $errorMsg]);
    }

    /**
     * Activar una suscripción tras verificar el pago
     */
    /**
     * Activar Suscripción (Confirmar Pago)
     */
    public function activateSubscription($id)
    {
        $token = session('auth_token');

        // Llamada directa al endpoint de activación de SUSCRIPCIÓN
        $response = Http::withToken($token)->withoutVerifying()
            ->post($this->baseUrl."/api/admin/suscripciones/{$id}/activar");

        if ($response->successful()) {
            return redirect()->route('dashboard.businesses')
                ->with('success', '¡Negocio activado correctamente! El cliente ya tiene acceso.');
        }

        return back()->withErrors(['api' => 'Error al activar: '.($response->json()['message'] ?? 'Error de servidor')]);
    }

    /**
     * Rechazar Suscripción (Pago Inválido)
     */
    public function rejectSubscription(Request $request, $id)
    {
        $token = session('auth_token');

        $response = Http::withToken($token)->withoutVerifying()
            ->post($this->baseUrl."/api/admin/suscripciones/{$id}/rechazar", [
                'motivo' => $request->motivo ?? 'Comprobante de pago no válido o datos incorrectos.',
            ]);

        if ($response->successful()) {
            return redirect()->route('dashboard.businesses')
                ->with('status', 'Pago rechazado. Se ha notificado al propietario.');
        }

        return back()->withErrors(['api' => 'No se pudo procesar el rechazo.']);
    }

    public function assignPlan(Request $request)
    {
        // 1. Validar la entrada local
        $request->validate([
            'negocio_id' => 'required',
            'suscripcion_id' => 'required',
        ]);

        $token = session('auth_token');
        $baseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';

        try {
            // 2. Petición POST a la API según tu captura de Postman
            $response = Http::withToken($token)->withoutVerifying()
                ->post($baseUrl.'/api/admin/planes/asignar', [
                    'negocio_id' => $request->negocio_id,
                    'suscripcion_id' => $request->suscripcion_id,
                ]);

            $data = $response->json();

            if ($response->successful() && ($data['success'] ?? false)) {
                return back()->with('success', '¡Plan asignado correctamente!');
            }

            return back()->withErrors(['api' => $data['message'] ?? 'Error al asignar el plan.']);

        } catch (\Exception $e) {
            return back()->withErrors(['api' => 'Error de conexión: '.$e->getMessage()]);
        }
    }
}
