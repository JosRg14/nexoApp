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
                $resHoy = $this->httpClient->get('/api/finanzas/ingresos-hoy');
                \Log::info('API finanzas/ingresos-hoy:', (array)$resHoy);
                $ingHoy = $resHoy['data'] ?? $resHoy['ingresos_hoy'] ?? $resHoy;
                $finanzas['ingresos_hoy']['total'] = $ingHoy['total'] ?? $ingHoy['ingresos'] ?? 0;
                $finanzas['ingresos_hoy']['variacion'] = $ingHoy['variacion'] ?? 0;
                
                $resCitas = $this->httpClient->get('/api/finanzas/citas-hoy');
                \Log::info('API finanzas/citas-hoy:', (array)$resCitas);
                $finanzas['citas_hoy'] = array_merge([
                    'total' => 0, 'completadas' => 0, 'pendientes' => 0, 'en_proceso' => 0, 'variacion' => 0
                ], $resCitas['data'] ?? $resCitas['citas_hoy'] ?? $resCitas);
                
                $resMes = $this->httpClient->get('/api/finanzas/ingresos-mes');
                \Log::info('API finanzas/ingresos-mes:', (array)$resMes);
                $ingMes = $resMes['data'] ?? $resMes['ingresos_mes'] ?? $resMes;
                $finanzas['ingresos_mes']['total'] = $ingMes['total'] ?? $ingMes['ingresos'] ?? 0;
                $finanzas['ingresos_mes']['variacion'] = $ingMes['variacion'] ?? 0;
                
                $resSem = $this->httpClient->get('/api/finanzas/ingresos-semanales');
                $finanzas['ingresos_semanales'] = $resSem['data'] ?? $resSem['ingresos_semanales'] ?? $resSem;
                
                $resTop = $this->httpClient->get('/api/finanzas/servicios-top', ['limite' => 5]);
                $finanzas['servicios_top'] = $resTop['data'] ?? $resTop['servicios_top'] ?? $resTop;
            } catch (\Exception $e) {
                \Log::warning('No se pudieron cargar las finanzas: ' . $e->getMessage());
            }

            // 4.5 Asegurar que los cálculos sean correctos (Backup de lógica)
            try {
                $resTodasCitas = $this->httpClient->get('/api/citas');
                $citasArray = $resTodasCitas['data'] ?? [];
                
                if (is_array($citasArray) && count($citasArray) > 0) {
                    $hoy = \Carbon\Carbon::now()->format('Y-m-d');
                    $mesActual = \Carbon\Carbon::now()->format('Y-m');

                    $ingresosHoy = 0;
                    $citasHoyTotal = 0;
                    $citasHoyCompletadas = 0;
                    $citasHoyPendientes = 0;
                    $citasHoyEnProceso = 0;
                    $ingresosMes = 0;

                    foreach ($citasArray as $cita) {
                        if (!isset($cita['fecha'])) continue;
                        
                        $fechaCita = \Carbon\Carbon::parse($cita['fecha'])->format('Y-m-d');
                        $mesCita = \Carbon\Carbon::parse($cita['fecha'])->format('Y-m');
                        $estado = strtolower($cita['estado'] ?? '');
                        // Obtener precio del servicio asociado o costo total
                        $precio = isset($cita['servicio']['precio']) ? (float)$cita['servicio']['precio'] : 
                                  (isset($cita['total']) ? (float)$cita['total'] : 0);

                        // Citas e Ingresos de Hoy
                        if ($fechaCita === $hoy) {
                            $citasHoyTotal++;
                            if ($estado === 'completada') {
                                $citasHoyCompletadas++;
                                $ingresosHoy += $precio;
                            } elseif ($estado === 'pendiente') {
                                $citasHoyPendientes++;
                            } elseif ($estado === 'en_proceso') {
                                $citasHoyEnProceso++;
                            }
                        }

                        // Ingresos del Mes Actual
                        if ($mesCita === $mesActual && $estado === 'completada') {
                            $ingresosMes += $precio;
                        }
                    }

                    // Forzar los valores calculados manualmente para priorizar la corrección
                    $finanzas['ingresos_hoy']['total'] = $ingresosHoy;
                    $finanzas['citas_hoy']['total'] = $citasHoyTotal;
                    $finanzas['citas_hoy']['completadas'] = $citasHoyCompletadas;
                    $finanzas['citas_hoy']['pendientes'] = $citasHoyPendientes;
                    $finanzas['citas_hoy']['en_proceso'] = $citasHoyEnProceso;
                    $finanzas['ingresos_mes']['total'] = $ingresosMes;
                    
                    \Log::info('Finanzas calculadas manualmente aplicadas', $finanzas);
                }
            } catch (\Exception $e) {
                \Log::error('Error validando calculos de citas manuales: ' . $e->getMessage());
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