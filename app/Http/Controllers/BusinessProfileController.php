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
            'ingresos_hoy' => ['total' => 0, 'variacion' => 0],
            'citas_hoy' => ['total' => 0, 'confirmadas' => 0, 'en_proceso' => 0, 'variacion' => 0],
            'ingresos_mes' => ['total' => 0, 'variacion' => 0],
            'ingresos_semanales' => ['dias' => [], 'ingresos' => []],
            'servicios_top' => []
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
            try {
                // Respuesta: {"success":true,"data":{"ingresos_hoy":3000,"variacion":100}}
                $resHoy = $this->httpClient->get('/api/finanzas/ingresos-hoy');
                $dataHoy = $resHoy['data'] ?? [];
                \Log::info('=== BFF FINANZAS - ingresos_hoy ===', (array)$dataHoy);
                $finanzas['ingresos_hoy'] = [
                    'total'     => $dataHoy['ingresos_hoy'] ?? 0,
                    'variacion' => $dataHoy['variacion']    ?? 0,
                ];
                
                // Respuesta: {"success":true,"data":{"total_citas":0,"confirmadas":0,"en_proceso":0,"variacion":-5}}
                $resCitas = $this->httpClient->get('/api/finanzas/citas-hoy');
                $dataCitas = $resCitas['data'] ?? [];
                \Log::info('=== BFF FINANZAS - citas_hoy ===', (array)$dataCitas);
                $finanzas['citas_hoy'] = [
                    'total'       => max($dataCitas['total_citas'] ?? 0, ($dataCitas['confirmadas'] ?? 0) + ($dataCitas['pendientes'] ?? 0) + ($dataCitas['en_proceso'] ?? 0) + ($dataCitas['canceladas'] ?? 0)),
                    'completadas' => $dataCitas['confirmadas'] ?? 0,
                    'pendientes'  => $dataCitas['pendientes']  ?? 0,
                    'en_proceso'  => $dataCitas['en_proceso']  ?? 0,
                    'canceladas'  => $dataCitas['canceladas']  ?? 0,
                    'variacion'   => $dataCitas['variacion']   ?? 0,
                ];
                
                // Respuesta: {"success":true,"data":{"ingresos_mes":3000,"variacion":100}}
                $resMes = $this->httpClient->get('/api/finanzas/ingresos-mes');
                $dataMes = $resMes['data'] ?? [];
                \Log::info('=== BFF FINANZAS - ingresos_mes ===', (array)$dataMes);
                $finanzas['ingresos_mes'] = [
                    'total'     => $dataMes['ingresos_mes'] ?? 0,
                    'variacion' => $dataMes['variacion']    ?? 0,
                ];
                
                // Respuesta: {"success":true,"data":{"dias":[...],"ingresos":[...]}}
                $resSem = $this->httpClient->get('/api/finanzas/ingresos-semanales');
                $finanzas['ingresos_semanales'] = $resSem['data'] ?? ['dias' => [], 'ingresos' => []];
                
                // Respuesta: {"success":true,"data":[{"nombre":"...","total_citas":1,"porcentaje":100}]}
                $resTop = $this->httpClient->get('/api/finanzas/servicios-top', ['limite' => 5]);
                $finanzas['servicios_top'] = $resTop['data'] ?? [];
            } catch (\Exception $e) {
                \Log::warning('No se pudieron cargar las finanzas: ' . $e->getMessage());
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
}