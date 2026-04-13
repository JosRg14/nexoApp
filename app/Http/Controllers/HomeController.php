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
            $page = $request->input('page', 1);
            $sort = $request->input('sort', 'recientes');
            
            $params = ['page' => $page];
            if ($categoria && $categoria !== 'todos') {
                $params['categoria'] = $categoria;
            }
            if ($sort) {
                // If the backend doesn't support 'sort', it will ignore it. 
                // But we pass it so it works if supported.
                $params['sort'] = $sort;
            }

            // Obtener negocios públicos usando HttpClient
            $response = $this->httpClient->getPublic('/api/negocios', $params);
            $negocios = $response['data'] ?? [];
            $meta = $response['meta'] ?? null;

            // Filtro manual (Fallback porque la API no filtra)
            if ($categoria && $categoria !== 'todos') {
                $negocios = array_filter($negocios, function($n) use ($categoria) {
                    $tipo = strtolower($n['tipo_negocio'] ?? '');
                    if ($categoria === 'otros') {
                        return !in_array($tipo, ['barberia', 'salon', 'peluqueria', 'spa']);
                    }
                    return $tipo === strtolower($categoria);
                });
                $negocios = array_values($negocios);
            }
            
            \Log::info('HomeController API Response (Filtered):', [
                'count' => count($negocios),
                'categoria' => $categoria,
                'meta' => $meta
            ]);
            
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
            }
            unset($negocio);
            
            // Fetch planes from the API
            $planesResponse = $this->httpClient->getPublic('/api/planes');
            $planes = $planesResponse['data'] ?? [];
            
        } catch (\Exception $e) {
            \Log::error('Error en HomeController: ' . $e->getMessage());
            $negocios = [];
            $meta = null;
            $planes = [];
        }
        
        return view('home', compact('negocios', 'categoria', 'meta', 'planes', 'sort'));
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