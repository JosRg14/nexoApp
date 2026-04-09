<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\HttpClient;
use App\Services\ExternalApi\ServiceService;
use App\Services\ExternalApi\EmployeeService;
use Illuminate\Http\Request;

class BusinessProfileController extends Controller
{
    protected ServiceService $serviceService;
    protected EmployeeService $employeeService;
    protected HttpClient $httpClient;

    public function __construct(
        ServiceService $serviceService,
        EmployeeService $employeeService,
        HttpClient $httpClient
    ) {
        $this->serviceService = $serviceService;
        $this->employeeService = $employeeService;
        $this->httpClient = $httpClient;
    }

    public function index()
    {
        $services = [];
        $employees = [];
        $negocio = [];
        $finanzas = [
            'con_cita' => [
                'ingresos_hoy' => ['total' => 0, 'variacion' => 0],
                'citas_hoy' => ['total' => 0, 'completadas' => 0, 'en_proceso' => 0, 'pendientes' => 0, 'canceladas' => 0, 'variacion' => 0],
                'ingresos_mes' => ['total' => 0, 'variacion' => 0],
                'ingresos_semanales' => ['dias' => [], 'ingresos' => []],
                'servicios_top' => []
            ],
            'sin_cita' => [
                'ingresos_hoy' => ['total' => 0, 'variacion' => 0],
                'citas_hoy' => ['total' => 0, 'completadas' => 0, 'en_proceso' => 0, 'pendientes' => 0, 'canceladas' => 0, 'variacion' => 0],
                'ingresos_mes' => ['total' => 0, 'variacion' => 0],
                'ingresos_semanales' => ['dias' => [], 'ingresos' => []],
                'servicios_top' => []
            ]
        ];

        try {
            // 1. Obtener los datos del negocio actual (esto ya está bien)
            $responseNegocio = $this->httpClient->get('/api/negocios/mi-negocio');
            $negocio = $responseNegocio['data'] ?? [];
            
            // 2. Obtener servicios del negocio autenticado (sin pasar negocio_id)
            // El TenantScope de la API filtrará automáticamente
            $responseServices = $this->httpClient->get('/api/mis-servicios');
            $services = collect($responseServices['data'] ?? [])->map(function ($item) {
                $imagenUrl = null;
                if (isset($item['imagen']) && $item['imagen']) {
                    $imagenUrl = rtrim(config('services.api.url'), '/') . '/' . ltrim($item['imagen'], '/');
                }
                return [
                    'id' => $item['id'] ?? ($item['id_servicio'] ?? null),
                    'nombre' => $item['nombre'] ?? '',
                    'descripcion' => $item['descripcion'] ?? '',
                    'precio' => $item['precio'] ?? 0,
                    'duracion' => $item['duracion'] ?? 0,
                    'imagen' => $imagenUrl,
                ];
            })->toArray();

            // 3. Obtener empleados del negocio autenticado (sin pasar negocio_id)
            $responseEmployees = $this->httpClient->get('/api/mis-empleados');
            $employees = collect($responseEmployees['data'] ?? [])->map(function ($emp) {
                return [
                    'id_empleado' => $emp['id_empleado'] ?? null,
                    'nombre' => $emp['nombre'] ?? '',
                    'app_paterno' => $emp['app_paterno'] ?? '',
                    'app_materno' => $emp['app_materno'] ?? '',
                    'correo' => $emp['correo'] ?? '',
                    'comision' => $emp['comision'] ?? 0,
                    'estado' => $emp['estado'] ?? 'activo',
                ];
            })->toArray();

            // 4. Obtener finanzas
            $tipos = ['con_cita', 'sin_cita'];
            foreach ($tipos as $tipo) {
                try {
                    $queryParams = ['tipo' => $tipo];

                    $resHoy = $this->httpClient->get('/api/finanzas/ingresos-hoy', $queryParams);
                    $dataHoy = $resHoy['data'] ?? [];
                    $finanzas[$tipo]['ingresos_hoy'] = [
                        'total'     => $dataHoy['ingresos_hoy'] ?? 0,
                        'variacion' => $dataHoy['variacion']    ?? 0,
                    ];
                    
                    $resCitas = $this->httpClient->get('/api/finanzas/citas-hoy', $queryParams);
                    $dataCitas = $resCitas['data'] ?? [];
                    $finanzas[$tipo]['citas_hoy'] = [
                        'total'       => $dataCitas['total_citas'] ?? 0,
                        'completadas' => $dataCitas['completadas'] ?? 0,
                        'pendientes'  => $dataCitas['pendientes']  ?? 0,
                        'en_proceso'  => $dataCitas['en_proceso']  ?? 0,
                        'canceladas'  => $dataCitas['canceladas']  ?? 0,
                        'variacion'   => $dataCitas['variacion']   ?? 0,
                    ];
                    
                    $resMes = $this->httpClient->get('/api/finanzas/ingresos-mes', $queryParams);
                    $dataMes = $resMes['data'] ?? [];
                    $finanzas[$tipo]['ingresos_mes'] = [
                        'total'     => $dataMes['ingresos_mes'] ?? 0,
                        'variacion' => $dataMes['variacion']    ?? 0,
                    ];
                    
                    $resSem = $this->httpClient->get('/api/finanzas/ingresos-semanales', $queryParams);
                    $finanzas[$tipo]['ingresos_semanales'] = $resSem['data'] ?? ['dias' => [], 'ingresos' => []];
                    
                    $resTop = $this->httpClient->get('/api/finanzas/servicios-top', array_merge($queryParams, ['limite' => 5]));
                    $finanzas[$tipo]['servicios_top'] = $resTop['data'] ?? [];
                } catch (\Exception $e) {
                    \Log::warning("No se pudieron cargar las finanzas tipo {$tipo}: " . $e->getMessage());
                }
            }



        } catch (\Exception $e) {
            $negocio = [];
            \Log::info('Error en BusinessProfileController: ' . $e->getMessage());
        }

        return view('business.profile', [
            'negocio' => $negocio,
            'services' => $services,
            'employees' => $employees,
            'finanzas' => $finanzas,
        ]);
    }

    public function update(Request $request)
    {
        try {
            // He fusionado todos los campos: los detallados de dirección y los de archivos
            $data = $request->only([
                'nombre',
                'tipo_negocio',
                'telefono',
                'redes_sociales',
                'rfc',
                'acerca_de',
                'calle',           
                'numero',          
                'colonia',         
                'ciudad',          
                'estado',          
                'codigo_postal',
                'direccion',      // Campo genérico por si tu API lo usa
                'foto_perfil',
                'banner',
                'fotos_galeria'
            ]);

            // Enviar datos a la API usando el servicio
            $this->serviceService->updateBusiness($data);

            return redirect()
                ->route('business.profile')
                ->with('success', 'Perfil del negocio actualizado correctamente');

        } catch (\Exception $e) {
            \Log::error('Error actualizando negocio: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el negocio: ' . $e->getMessage());
        }
    }

    public function clientesFrecuentes(Request $request)
    {
        $limit = $request->get('limit', 20);
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        
        $response = $this->httpClient->get('/api/clientes-frecuentes', [
            'limit' => $limit,
            'desde' => $desde,
            'hasta' => $hasta
        ]);
        
        return response()->json($response);
    }

    public function listarPromociones()
    {
        $response = $this->httpClient->get('/api/promociones');
        return response()->json($response);
    }

    public function crearPromocion(Request $request)
    {
        $response = $this->httpClient->post('/api/promociones', $request->all());
        return response()->json($response);
    }

    public function actualizarPromocion(Request $request, $id)
    {
        // El framework Laravel podría enviar un _method=PUT o hacer un PUT real
        // HttpClient suele soportar put directo.
        $response = $this->httpClient->put("/api/promociones/{$id}", $request->all());
        return response()->json($response);
    }

    public function eliminarPromocion($id)
    {
        $response = $this->httpClient->delete("/api/promociones/{$id}");
        return response()->json($response);
    }

    public function listarPromocionesCliente($clienteId)
    {
        $response = $this->httpClient->get("/api/clientes/{$clienteId}/promociones");
        return response()->json($response);
    }

    public function asignarPromocionCliente(Request $request, $clienteId)
    {
        $response = $this->httpClient->post("/api/clientes/{$clienteId}/promociones", $request->all());
        return response()->json($response);
    }

    public function eliminarPromocionCliente($clienteId, $promoId)
    {
        $response = $this->httpClient->delete("/api/clientes/{$clienteId}/promociones/{$promoId}");
        return response()->json($response);
    }
}