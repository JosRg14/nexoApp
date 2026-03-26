<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NegocioController extends Controller
{
    public function show($id)
    {
        try {
            $baseUrl = rtrim(config('services.api.url'), '/');
            
            // Obtener datos del negocio
            $responseNegocio = Http::timeout(30)
                ->withOptions(['verify' => false])
                ->get($baseUrl . '/api/negocios/' . $id);
            
            if (!$responseNegocio->successful()) {
                abort(404, 'Negocio no encontrado');
            }
            
            $negocio = $responseNegocio->json('data');
            
            // Obtener servicios del negocio
            $responseServicios = Http::timeout(30)
                ->withOptions(['verify' => false])
                ->get($baseUrl . '/api/servicios', [
                    'negocio_id' => $id
                ]);
            $servicios = $responseServicios->successful() ? $responseServicios->json('data') : [];
            
            // Obtener empleados del negocio
            $responseEmpleados = Http::timeout(30)
                ->withOptions(['verify' => false])
                ->get($baseUrl . '/api/empleados', [
                    'negocio_id' => $id
                ]);
            $empleados = $responseEmpleados->successful() ? $responseEmpleados->json('data') : [];
            
            // Obtener reseñas
            $responseResenas = Http::timeout(30)
                ->withOptions(['verify' => false])
                ->get($baseUrl . '/api/negocios/' . $id . '/resenas');
            $resenas = $responseResenas->successful() ? $responseResenas->json('data') : [];
            
            return view('negocio.show', compact('negocio', 'servicios', 'empleados', 'resenas'));
            
        } catch (\Exception $e) {
            \Log::error('Error en NegocioController: ' . $e->getMessage());
            abort(404, 'Error al cargar el negocio');
        }
    }
}