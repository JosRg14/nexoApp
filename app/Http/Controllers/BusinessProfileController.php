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
        $token = session('auth_token');
        
        // Obtener negocio
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://devlink-servidorapi.td60xq.easypanel.host/api/negocios/mi-negocio');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $responseNegocio = json_decode($response, true);
        $negocio = $responseNegocio['data'] ?? [];
        
        // Obtener ID del negocio
        $negocioId = $negocio['id_negocio'] ?? 2; // Si no viene, usa 2 como fallback
        
        // Obtener servicios
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://devlink-servidorapi.td60xq.easypanel.host/api/servicios?negocio_id=' . $negocioId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $responseServices = json_decode($response, true);
        
        $services = collect($responseServices['data'] ?? [])->map(function ($item) {
            // Completar URL de la imagen
            $imagenUrl = null;
            if (isset($item['imagen']) && $item['imagen']) {
                $imagenUrl = 'https://devlink-servidorapi.td60xq.easypanel.host' . $item['imagen'];
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

        // Obtener empleados
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://devlink-servidorapi.td60xq.easypanel.host/api/empleados?negocio_id=' . $negocioId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $responseEmployees = json_decode($response, true);

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