<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\ServiceService;
use App\Services\ExternalApi\EmployeeService;
use Illuminate\Http\Request;

class BusinessProfileController extends Controller
{

    protected ServiceService $serviceService;
    protected EmployeeService $employeeService;

    public function __construct(
        ServiceService $serviceService,
        EmployeeService $employeeService
    ) {
        $this->serviceService = $serviceService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {

        $services = [];
        $employees = [];
        $negocio = [];

        try {

            // Obtener negocio
            $responseNegocio = $this->serviceService->getBusiness();
            $negocio = $responseNegocio['data'] ?? [];

            // Obtener servicios
            $responseServices = $this->serviceService->list();

            $services = collect($responseServices['data'] ?? [])->map(function ($item) {
                return [
                    'id' => $item['id'] ?? null,
                    'nombre' => $item['nombre'] ?? '',
                    'descripcion' => $item['descripcion'] ?? '',
                    'precio' => $item['precio'] ?? 0,
                    'duracion' => $item['duracion'] ?? 0,
                    'imagen' => isset($item['imagen'])
                        ? rtrim(config('services.api.url'), '/') . '/' . ltrim($item['imagen'], '/')
                        : null,
                ];
            })->toArray();

            // Obtener empleados
            $responseEmployees = $this->employeeService->list();

            $employees = collect($responseEmployees['data'] ?? [])
->map(function ($emp) {
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


        } catch (\Exception $e) {

            $negocio = session('negocio');
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

            // enviar datos a la API
            $this->serviceService->updateBusiness($data);

            return redirect()
                ->route('business.profile')
                ->with('success', 'Negocio actualizado correctamente');

        } catch (\Exception $e) {

            return back()->with('error', 'Error al actualizar el negocio');
        }
    }
}