<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NegocioController extends Controller
{
    public function show($id)
{
    try {
        $apiBaseUrl = 'https://devlink-servidorapi.td60xq.easypanel.host';
        
        // Obtener datos del negocio
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiBaseUrl . '/api/negocios/' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $negocioData = json_decode($response, true);
        $negocio = $negocioData['data'] ?? [];
        
        // Completar URLs de imágenes del negocio
        if (isset($negocio['foto_perfil']) && $negocio['foto_perfil']) {
            $negocio['foto_perfil'] = $apiBaseUrl . $negocio['foto_perfil'];
        }
        if (isset($negocio['banner']) && $negocio['banner']) {
            $negocio['banner'] = $apiBaseUrl . $negocio['banner'];
        }
        
        // Obtener servicios
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiBaseUrl . '/api/servicios?negocio_id=' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $serviciosData = json_decode($response, true);
        $servicios = collect($serviciosData['data'] ?? [])->map(function ($servicio) use ($apiBaseUrl) {
            // Completar URL de la imagen
            $imagenUrl = null;
            if (isset($servicio['imagen']) && $servicio['imagen']) {
                $imagenUrl = $apiBaseUrl . $servicio['imagen'];
            }
            
            return [
                'id' => $servicio['id'] ?? $servicio['id_servicio'],
                'id_servicio' => $servicio['id'] ?? $servicio['id_servicio'],
                'nombre' => $servicio['nombre'],
                'descripcion' => $servicio['descripcion'] ?? '',
                'precio' => $servicio['precio'] ?? 0,
                'duracion' => $servicio['duracion'] ?? 0,
                'imagen' => $imagenUrl,
            ];
        })->toArray();
        
        // Obtener empleados
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiBaseUrl . '/api/empleados?negocio_id=' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
    
        $empleadosData = json_decode($response, true);
        $empleados = $empleadosData['data'] ?? [];
        
        // Obtener reseñas
        $resenas = [];
        
        return view('negocio.show', compact('negocio', 'servicios', 'empleados', 'resenas'));
        
    } catch (\Exception $e) {
        \Log::error('Error en NegocioController: ' . $e->getMessage());
        abort(404, 'Error al cargar el negocio');
    }
}
}