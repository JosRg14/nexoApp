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
            
            $apiBaseUrl = rtrim(config('services.api.url'), '/');
            // Extraer imágenes de la relación (o adaptar strings para compatibilidad con las vistas)
            if (isset($negocio['imagenes']) && is_array($negocio['imagenes'])) {
                $negocio['foto_perfil'] = collect($negocio['imagenes'])->where('tipo', 'perfil_negocio')->first();
                $negocio['banner'] = collect($negocio['imagenes'])->where('tipo', 'banner_negocio')->first();
            } else {
                if (isset($negocio['foto_perfil']) && is_string($negocio['foto_perfil'])) {
                    $negocio['foto_perfil'] = ['url_imagen' => $negocio['foto_perfil']];
                }
                if (isset($negocio['banner']) && is_string($negocio['banner'])) {
                    $negocio['banner'] = ['url_imagen' => $negocio['banner']];
                }
            }
            
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