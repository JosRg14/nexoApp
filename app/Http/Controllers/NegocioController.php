<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalApi\HttpClient;

class NegocioController extends Controller
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function show($id)
    {
        try {
            // Obtener datos del negocio
            $response = $this->httpClient->getPublic('/api/negocios/' . $id);
            $negocio = $response['data'] ?? [];
            
            \Log::info('NegocioController API Response:', [
                'id' => $id,
                'tiene_imagenes' => isset($negocio['imagenes']),
                'imagenes' => $negocio['imagenes'] ?? [],
                'foto_perfil' => $negocio['foto_perfil'] ?? null,
                'banner' => $negocio['banner'] ?? null
            ]);
            
            $apiBaseUrl = rtrim(config('services.api.url'), '/');
            // Procesar foto_perfil
            $fotoUrl = null;
            if (isset($negocio['imagenes']) && is_array($negocio['imagenes'])) {
                foreach ($negocio['imagenes'] as $img) {
                    if (isset($img['tipo']) && $img['tipo'] === 'perfil_negocio') {
                        $fotoUrl = $img['url_imagen'] ?? null;
                        break;
                    }
                }
            }
            if (!$fotoUrl && isset($negocio['foto_perfil']) && $negocio['foto_perfil']) {
                $fotoUrl = $negocio['foto_perfil'];
            }
            if ($fotoUrl && !\Illuminate\Support\Str::startsWith($fotoUrl, 'http')) {
                $fotoUrl = $apiBaseUrl . (\Illuminate\Support\Str::startsWith($fotoUrl, '/') ? '' : '/') . $fotoUrl;
            }
            $negocio['foto_perfil'] = $fotoUrl;

            // Misma lógica para banner
            $bannerUrl = null;
            if (isset($negocio['imagenes']) && is_array($negocio['imagenes'])) {
                foreach ($negocio['imagenes'] as $img) {
                    if (isset($img['tipo']) && $img['tipo'] === 'banner_negocio') {
                        $bannerUrl = $img['url_imagen'] ?? null;
                        break;
                    }
                }
            }
            if (!$bannerUrl && isset($negocio['banner']) && $negocio['banner']) {
                $bannerUrl = $negocio['banner'];
            }
            if ($bannerUrl && !\Illuminate\Support\Str::startsWith($bannerUrl, 'http')) {
                $bannerUrl = $apiBaseUrl . (\Illuminate\Support\Str::startsWith($bannerUrl, '/') ? '' : '/') . $bannerUrl;
            }
            $negocio['banner'] = $bannerUrl;
            // Obtener horarios del negocio
            $horariosResponse = $this->httpClient->getPublic('/api/negocios/' . $id . '/horarios');
            $horarios = [];
            
            if (isset($horariosResponse['success']) && $horariosResponse['success'] && isset($horariosResponse['data'])) {
                $horarios = $horariosResponse['data'];
            }
            
            // Formatear horarios para la vista
            $horariosFormateados = $this->formatearHorarios($horarios);
            
            // Obtener servicios
            $serviciosResponse = $this->httpClient->getPublic('/api/servicios', ['negocio_id' => $id]);
            $servicios = collect($serviciosResponse['data'] ?? [])->map(function ($servicio) use ($apiBaseUrl) {
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
            $empleadosResponse = $this->httpClient->getPublic('/api/empleados', ['negocio_id' => $id]);
            $empleados = $empleadosResponse['data'] ?? [];
            
            // Obtener reseñas (endpoint público)
            $resenas = [];
            try {
                $resenasResponse = $this->httpClient->getPublic('/api/negocios/' . $id . '/resenas');
                $resenas = $resenasResponse['data'] ?? [];
            } catch (\Exception $e) {
                // Si no hay reseñas, continuar con array vacío
            }
            
            return view('negocio.show', compact('negocio', 'servicios', 'empleados', 'resenas', 'horariosFormateados'));
            
        } catch (\Exception $e) {
            \Log::error('Error en NegocioController: ' . $e->getMessage());
            abort(404, 'Error al cargar el negocio');
        }
    }
    
    /**
     * Formatear los horarios para la vista
     */
    private function formatearHorarios($horarios)
    {
        $horariosFormateados = [];
        $diasMap = [
            'lunes' => 'Lunes', 
            'martes' => 'Martes', 
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves', 
            'viernes' => 'Viernes', 
            'sabado' => 'Sábado', 
            'domingo' => 'Domingo'
        ];
        
        foreach ($horarios as $horario) {
            $dia = $horario['dia_semana'];
            $horariosFormateados[] = [
                'dia' => $diasMap[$dia] ?? ucfirst($dia),
                'abierto' => $horario['abierto'],
                'horarios' => $this->formatearHorarioBloques($horario)
            ];
        }
        
        // Ordenar horarios según el orden de los días
        $ordenDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        usort($horariosFormateados, function($a, $b) use ($ordenDias) {
            return array_search($a['dia'], $ordenDias) - array_search($b['dia'], $ordenDias);
        });
        
        return $horariosFormateados;
    }
    
    /**
     * Formatear los bloques de horario para mostrar
     */
    private function formatearHorarioBloques($horario)
    {
        if (!$horario['abierto']) {
            return ['Cerrado'];
        }
        
        $bloques = [];
        
        // Primer bloque
        if (!empty($horario['hora_apertura']) && !empty($horario['hora_cierre'])) {
            $apertura = substr($horario['hora_apertura'], 0, 5);
            $cierre = substr($horario['hora_cierre'], 0, 5);
            $bloques[] = "$apertura - $cierre";
        }
        
        // Segundo bloque
        if (!empty($horario['hora_apertura_2']) && !empty($horario['hora_cierre_2'])) {
            $apertura2 = substr($horario['hora_apertura_2'], 0, 5);
            $cierre2 = substr($horario['hora_cierre_2'], 0, 5);
            $bloques[] = "$apertura2 - $cierre2";
        }
        
        // Si no hay bloques válidos pero el día está abierto
        if (empty($bloques)) {
            $bloques[] = 'Horario no especificado';
        }
        
        return $bloques;
    }
}