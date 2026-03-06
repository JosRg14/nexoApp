<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ExternalApi\ServiceService;
use Illuminate\Http\Request;
use RuntimeException;

class ServiceController extends Controller
{
    protected ServiceService $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
        // Apply session token injection, role check and any auth middleware you already use
        $this->middleware(['auth.session', 'inject.api.token', 'role:admin']);
    }

    /**
     * Show list of services.
     */
    public function index()
{
    try {
        $response = $this->service->list();

        $services = collect($response['data'] ?? [])->map(function ($item) {
            return [
                'id' => $item['id'] ?? null,
                'nombre' => $item['nombre'] ?? '', // 🔥 CORREGIDO
                'descripcion' => $item['descripcion'] ?? '',
                'precio' => $item['precio'] ?? 0,
                'duracion' => $item['duracion'] ?? 0,
                'imagen' => isset($item['imagen'])
    ? config('services.api.url') . $item['imagen']
    : null, 
            ];
        })->toArray();

       

    } catch (\RuntimeException $e) {
        $services = [];
        session()->flash('api', $e->getMessage());
    }

    return view('business.profile', compact('services'));
}

    /**
     * Store a new service.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
    'nombre' => 'required|string|max:100',
    'descripcion' => 'nullable|string|max:255',
    'precio' => 'required|numeric|min:1|max:10000',
    'duracion' => 'required|integer|min:5|max:480',
], [
    'nombre.max' => 'El nombre no puede superar 100 caracteres.',
    'precio.min' => 'El precio debe ser mayor a 0.',
    'duracion.max' => 'La duración no puede ser mayor a 8 horas.',
]);

    try {
        $this->service->create([
    'nombre_servicio' => $validated['nombre'],
    'descripcion' => $validated['descripcion'],
    'precio' => $validated['precio'],
    'duracion_estimada' => $validated['duracion'],
]);
        return redirect()->back()
        ->with('status', 'Servicio creado');
    } catch (\RuntimeException $e) {
        return redirect()->back()->withErrors(['api' => $e->getMessage()])->withInput();
    }
}

public function update(Request $request, int $id)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:100',
        'descripcion' => 'nullable|string|max:255',
        'precio' => 'required|numeric|min:1|max:10000',
        'duracion' => 'required|integer|min:5|max:480',
    ]);

    try {

        $payload = [
            'nombre_servicio' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'precio' => $validated['precio'],
            'duracion_estimada' => $validated['duracion'],
        ];

        $this->service->update($id, $payload);

        return redirect()->back()
            ->with('status', 'Servicio actualizado');

    } catch (\RuntimeException $e) {
        return redirect()->back()
            ->withErrors(['api' => $e->getMessage()]);
    }
}

public function destroy(int $id)
{
    try {

        $this->service->delete($id);

        return redirect()->back()
            ->with('status', 'Servicio eliminado correctamente');

    } catch (\RuntimeException $e) {
        return redirect()->back()
            ->withErrors(['api' => $e->getMessage()]);
    }
}

}
?>
