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

            // Obtener negocio del admin autenticado
            $responseNegocio = $this->serviceService->getBusiness();
            $negocio = $responseNegocio['data'] ?? [];

            // Obtener el ID del negocio
            $negocioId = $negocio['id_negocio'] ?? null;

            // Obtener servicios SOLO de este negocio
            $params = [];
            if ($negocioId) {
                $params['negocio_id'] = $negocioId;
            }
            
            $responseServices = $this->serviceService->list($params);

            $services = collect($responseServices['data'] ?? [])->map(function ($item) {
                return [
                    'id' => $item['id_servicio'] ?? $item['id'],
                    'nombre' => $item['nombre_servicio'] ?? $item['nombre'],
                    'descripcion' => $item['descripcion'] ?? '',
                    'precio' => $item['precio'] ?? 0,
                    'duracion' => $item['duracion_estimada'] ?? $item['duracion'] ?? 0,
                    'imagen' => isset($item['imagen'])
                        ? rtrim(config('services.api.url'), '/') . '/' . ltrim($item['imagen'], '/')
                        : null,
                ];
            })->toArray();

            // Obtener empleados SOLO de este negocio
            $responseEmployees = $this->employeeService->list($params);

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

        } catch (\Exception $e) {
            $negocio = session('negocio');
            \Log::error('Error en BusinessProfileController: ' . $e->getMessage());
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