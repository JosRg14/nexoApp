<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\HttpClient;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Mostrar la página de inicio con los negocios
     */
    public function index(Request $request)
    {
        try {
            $categoria = $request->input('categoria', '');
            // Obtener negocios públicos usando HttpClient
            $response = $this->httpClient->getPublic('/api/negocios');
            $negocios = $response['data'] ?? [];
            
            \Log::info('HomeController API Response:', [
                'count' => count($negocios),
                'primer_negocio_imagenes' => ($negocios[0]['imagenes'] ?? 'No tiene imagenes'),
                'primer_negocio_foto' => ($negocios[0]['foto_perfil'] ?? 'No tiene foto_perfil directly')
            ]);
            
            \Log::info('=== ESTRUCTURA COMPLETA DEL PRIMER NEGOCIO ===', [
                'negocio_completo' => $negocios[0] ?? 'No hay negocios'
            ]);
            
            if ($categoria && $categoria !== 'todos') {
                $negocios = array_filter($negocios, function($negocio) use ($categoria) {
                    return ($negocio['tipo_negocio'] ?? '') === $categoria;
                });
                $negocios = array_values($negocios); // Reindexar array
            }
            $apiBaseUrl = rtrim(config('services.api.url'), '/');
            // Completar URLs de imágenes estructurando la respuesta en forma de string final para la vista
            foreach ($negocios as &$negocio) {
                
                $fotoUrl = null;

                // Lógica para procesar la imagen
                if (isset($negocio['imagenes']) && is_array($negocio['imagenes']) && count($negocio['imagenes']) > 0) {
                    // Buscar imagen de tipo perfil_negocio
                    foreach ($negocio['imagenes'] as $img) {
                        if (isset($img['tipo']) && $img['tipo'] === 'perfil_negocio') {
                            $fotoUrl = $img['url_imagen'] ?? null;
                            break;
                        }
                    }
                    
                    // Si no encontró por tipo, tomar la primera
                    if (!$fotoUrl) {
                        $fotoUrl = $negocio['imagenes'][0]['url_imagen'] ?? $negocio['imagenes'][0] ?? null;
                    }
                }

                // Si la API ya devolvió foto_perfil directamente
                if (!$fotoUrl && isset($negocio['foto_perfil']) && $negocio['foto_perfil']) {
                    $fotoUrl = $negocio['foto_perfil'];
                }

                // Asignar la URL completa con el base de la API si es necesario
                if ($fotoUrl && !\Illuminate\Support\Str::startsWith($fotoUrl, 'http')) {
                    $apiBaseUrl = rtrim(config('services.api.url'), '/');
                    $fotoUrl = $apiBaseUrl . (\Illuminate\Support\Str::startsWith($fotoUrl, '/') ? '' : '/') . $fotoUrl;
                }

                $negocio['foto_perfil'] = $fotoUrl;

                // LOG DETALLADO
                \Log::info('DEBUG NEGOCIO: ' . ($negocio['nombre'] ?? 'Sin nombre'), [
                    'id' => $negocio['id_negocio'] ?? $negocio['id'] ?? null,
                    'imagenes_raw' => $negocio['imagenes'] ?? 'NO EXISTE O ESTÁ VACÍO',
                    'fotoUrl_generada' => $fotoUrl,
                    'foto_perfil_final' => $negocio['foto_perfil']
                ]);
            }
            unset($negocio);
        } catch (\Exception $e) {
            \Log::error('Error en HomeController: ' . $e->getMessage());
            $negocios = [];
        }
        
        return view('home', compact('negocios', 'categoria'));
    }
    
    /**
     * Mostrar página de inicio con datos estáticos (fallback)
     * Útil cuando la API no está disponible
     */
    public function indexFallback()
    {
        $negocios = [
            [
                'id' => 1,
                'nombre' => 'The Gentlemen\'s Club',
                'descripcion' => 'Corte clásico y afeitado tradicional con toalla caliente.',
                'calificacion' => 4.9,
                'foto_perfil' => null,
                'tipo_negocio' => 'barberia'
            ],
            [
                'id' => 2,
                'nombre' => 'Urban Fade Studio',
                'descripcion' => 'Especialistas en degradados y diseños urbanos.',
                'calificacion' => 4.8,
                'foto_perfil' => null,
                'tipo_negocio' => 'barberia'
            ],
            [
                'id' => 3,
                'nombre' => 'Razor & Blade',
                'descripcion' => 'Barbería ejecutiva de alto nivel.',
                'calificacion' => 5.0,
                'foto_perfil' => null,
                'tipo_negocio' => 'barberia'
            ],
            [
                'id' => 4,
                'nombre' => 'Legacy Barbershop',
                'descripcion' => 'Heredando la tradición del buen corte.',
                'calificacion' => 4.9,
                'foto_perfil' => null,
                'tipo_negocio' => 'barberia'
            ],
        ];
        
        return view('home', compact('negocios'));
    }
}