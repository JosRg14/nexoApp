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

        try {
            // 1. Obtener los datos del negocio actual
            $responseNegocio = $this->httpClient->get('/api/negocios/mi-negocio');
            $negocio = $responseNegocio['data'] ?? [];
            
            $negocioId = $negocio['id_negocio'] ?? null;
            
            if ($negocioId) {
                // 2. Obtener servicios filtrados por el ID del negocio
                $responseServices = $this->httpClient->get('/api/servicios', ['negocio_id' => $negocioId]);
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

                // 3. Obtener empleados filtrados por el ID del negocio
                $responseEmployees = $this->httpClient->get('/api/empleados', ['negocio_id' => $negocioId]);
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
            }

        } catch (\Exception $e) {
            $negocio = [];
            \Log::info('Admin sin negocio registrado o error en API: ' . $e->getMessage());
        }

        return view('business.profile', [
            'negocio' => $negocio,
            'services' => $services,
            'employees' => $employees,
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