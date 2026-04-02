<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\HttpClient;

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
    public function index()
    {
        try {
            // Obtener negocios públicos usando HttpClient
            $response = $this->httpClient->getPublic('/api/negocios');
            $negocios = $response['data'] ?? [];
            
            \Log::info('HomeController API Response:', [
                'count' => count($negocios),
                'primer_negocio_imagenes' => ($negocios[0]['imagenes'] ?? 'No tiene imagenes'),
                'primer_negocio_foto' => ($negocios[0]['foto_perfil'] ?? 'No tiene foto_perfil directly')
            ]);
            
            $apiBaseUrl = rtrim(config('services.api.url'), '/');
            // Completar URLs de imágenes estructurando la respuesta en forma de string final para la vista
            foreach ($negocios as &$negocio) {
                $fotoUrl = null;
                if (isset($negocio['imagenes']) && is_array($negocio['imagenes'])) {
                    $fotoObj = collect($negocio['imagenes'])->where('tipo', 'perfil_negocio')->first();
                    if ($fotoObj && isset($fotoObj['url_imagen'])) {
                        $fotoUrl = $apiBaseUrl . $fotoObj['url_imagen'];
                    }
                } elseif (isset($negocio['foto_perfil']) && is_string($negocio['foto_perfil'])) {
                    $fotoUrl = \Illuminate\Support\Str::startsWith($negocio['foto_perfil'], 'http') 
                        ? $negocio['foto_perfil'] 
                        : $apiBaseUrl . $negocio['foto_perfil'];
                }
                
                $negocio['foto_perfil'] = $fotoUrl;
            }
        } catch (\Exception $e) {
            \Log::error('Error en HomeController: ' . $e->getMessage());
            $negocios = [];
        }
        
        return view('home', compact('negocios'));
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