<?php

namespace App\Http\Controllers;

use App\Services\ExternalApi\BusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio con los negocios
     */
    public function index()
    {
        // Consumir la API para obtener los negocios
        $response = Http::timeout(10)->get(config('services.api.url') . '/api/negocios');
        
        $negocios = [];
        
        if ($response->successful()) {
            $negocios = $response->json('data') ?? [];
        }
        
        // Si la API no devuelve datos, mostrar array vacío
        return view('home', compact('negocios'));
    }
    
    /**
     * Mostrar página de inicio con datos estáticos (fallback)
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
            // ... más negocios de ejemplo
        ];
        
        return view('home', compact('negocios'));
    }
}