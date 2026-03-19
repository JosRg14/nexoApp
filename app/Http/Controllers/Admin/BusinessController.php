<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ExternalApi\BusinessService;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected BusinessService $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
        $this->middleware(['auth.session', 'inject.api.token', 'role:admin']);

    }

    public function index(Request $request)
    {
        try {
            // Pasamos los filtros que vengan en la URL (estado, fecha)
            $filters = $request->only(['estado', 'fecha_desde']);
            $response = $this->businessService->list($filters);
            $businesses = collect($response['data'] ?? [])->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['nombre'],
                    'owner' => $item['propietario'],
                    'status' => $item['estado'], // 'activo', 'suspendido', 'pendiente'
                    'revenue' => $item['ingresos'] ?? 0,
                    'category' => 'Negocio' // La API actual no lo manda, lo seteamos por defecto
                ];
            });

            return view('admin.businesses.index', compact('businesses'));

        } catch (\RuntimeException $e) {
            // Si el HttpClient lanza error, lo mandamos a la vista
            return view('admin.businesses.index', ['businesses' => []])
                   ->with('error', 'Error de API: ' . $e->getMessage());
        }
    }
}
?>