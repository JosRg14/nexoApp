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
            // Obtener negocio usando HttpClient
            $responseNegocio = $this->httpClient->get('/api/negocios/mi-negocio');
            $negocio = $responseNegocio['data'] ?? [];
            
            $negocioId = $negocio['id_negocio'] ?? null;
            
            if ($negocioId) {
                // Obtener servicios y empleados solo si hay negocio
                $responseServices = $this->httpClient->get('/api/servicios', ['negocio_id' => $negocioId]);
                $services = collect($responseServices['data'] ?? [])->map(function ($item) {
                    $imagenUrl = null;
                    if (isset($item['imagen']) && $item['imagen']) {
                        $imagenUrl = rtrim(config('services.api.url'), '/') . $item['imagen'];
                    }
                    return [
                        'id' => $item['id'] ?? $item['id_servicio'],
                        'nombre' => $item['nombre'],
                        'descripcion' => $item['descripcion'] ?? '',
                        'precio' => $item['precio'] ?? 0,
                        'duracion' => $item['duracion'] ?? 0,
                        'imagen' => $imagenUrl,
                    ];
                })->toArray();

                $responseEmployees = $this->httpClient->get('/api/empleados', ['negocio_id' => $negocioId]);
                $employees = collect($responseEmployees['data'] ?? [])->map(function ($emp) {
                    return [
                        'id_empleado' => $emp['id_empleado'] ?? null,
                        'nombre' => $emp['nombre'] ?? '',
                        'app_paterno' => $emp['app_paterno'] ?? '',
                        'app_materno' => $emp['app_materno'] ?? '',
                        'correo' => $emp['correo'] ?? '',
                        'comision' => $emp['comision'] ?? 0,
                        'estado' => $emp['estado'] ?? 'activo'
                    ];
                })->toArray();
            }

        } catch (\Exception $e) {
            // Si falla (porque no tiene negocio), simplemente dejamos $negocio vacío
            $negocio = [];
            \Log::info('Admin sin negocio registrado - mostrando formulario de registro');
        }

        return view('business.profile', [
            'negocio' => $negocio,
            'services' => $services,
            'employees' => $employees
        ]);
    }

    public function update(Request $request)
    {
        try {
            $data = $request->only([
                'nombre',
                'tipo_negocio',
                'telefono',
                'redes_sociales',
                'rfc',
                'acerca_de',
                'direccion',
                'foto_perfil',
                'banner',
                'fotos_galeria'
            ]);

            // enviar datos a la API usando el servicio (que ya usa HttpClient)
            $this->serviceService->updateBusiness($data);

            return redirect()
                ->route('business.profile')
                ->with('success', 'Negocio actualizado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el negocio');
        }
    }
}