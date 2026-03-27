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
    // PRUEBA DIRECTA - SIN NINGUNA LÓGICA COMPLEJA
    $token = session('auth_token');
    
    // Llamada directa a la API con cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://devlink-servidorapi.td60xq.easypanel.host/api/servicios?negocio_id=2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Decodificar respuesta
    $data = json_decode($response, true);
    
    // Enviar a la vista
    return view('business.profile', [
        'negocio' => ['nombre' => 'Mi Negocio', 'id_negocio' => 2],
        'services' => $data['data'] ?? [],
        'employees' => []
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