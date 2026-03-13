<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\ServiceService;
use Illuminate\Http\Request;

class BusinessProfileController extends Controller
{

    protected ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {

        $services = [];
        $negocio = [];

        try {

            // obtener negocio completo
            $responseNegocio = $this->serviceService->getBusiness();
            $negocio = $responseNegocio['data'] ?? [];

            // obtener servicios

            $response = $this->serviceService->list();

$services = collect($response['data'] ?? [])->map(function ($item) {
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

        } catch (\Exception $e) {

            $negocio = session('negocio');
        }

        return view('business.profile', [
            'negocio' => $negocio,
            'services' => $services
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