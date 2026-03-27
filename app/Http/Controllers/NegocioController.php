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
            
            // Obtener horarios del negocio
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiBaseUrl . '/api/negocios/' . $id . '/horarios');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            
            $horariosData = json_decode($response, true);
            $horarios = [];
            
            if (isset($horariosData['success']) && $horariosData['success'] && isset($horariosData['data'])) {
                $horarios = $horariosData['data'];
            }
            
            // Formatear horarios para la vista
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
            
            return view('negocio.show', compact('negocio', 'servicios', 'empleados', 'resenas', 'horariosFormateados'));
            
        } catch (\Exception $e) {
            \Log::error('Error en NegocioController: ' . $e->getMessage());
            abort(404, 'Error al cargar el negocio');
        }
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
        if ($horario['hora_apertura'] && $horario['hora_cierre']) {
            $apertura = substr($horario['hora_apertura'], 0, 5);
            $cierre = substr($horario['hora_cierre'], 0, 5);
            $bloques[] = "$apertura - $cierre";
        }
        
        // Segundo bloque
        if ($horario['hora_apertura_2'] && $horario['hora_cierre_2']) {
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