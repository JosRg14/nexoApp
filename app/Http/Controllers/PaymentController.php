<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalApi\HttpClient;
use RuntimeException;

class PaymentController extends Controller
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Mostrar página de planes disponibles
     */
    public function planes()
    {
        try {
            $response = $this->httpClient->get('/api/planes');
            $planes = $response['data'] ?? [];
        } catch (RuntimeException $e) {
            $planes = [];
        }

        return view('payment.plans', compact('planes'));
    }

    /**
     * Iniciar checkout de Stripe
     */
    public function checkout(Request $request)
    {
        $request->validate(['price_id' => 'required|string']);

        try {
            $response = $this->httpClient->post('/api/pagos/checkout', [
                'price_id'    => $request->price_id,
                'success_url' => route('payment.success'),
                'cancel_url'  => route('payment.cancel'),
            ]);

            $url = $response['url'] ?? ($response['data']['url'] ?? null);

            if ($url) {
                return redirect()->away($url);
            }
        } catch (RuntimeException $e) {
            // fallthrough
        }

        return redirect()->route('payment.plans')
            ->with('error', 'No se pudo iniciar el proceso de pago. Inténtalo de nuevo.');
    }

    /**
     * Página de éxito después del pago con Stripe
     */
    public function success()
    {
        if (session('registro_negocio_nombre')) {
            try {
                $this->httpClient->post('/api/negocio/completar', [
                    'nombre'      => session('registro_negocio_nombre'),
                    'tipo_negocio'=> session('registro_negocio_tipo'),
                    'estado'      => 'activo',
                    'metodo_pago' => 'stripe',
                ]);
            } catch (RuntimeException $e) {
                // El negocio puede haberse creado igualmente vía webhook
            }

            session()->flash('nombre_negocio', session('registro_negocio_nombre'));
            session()->forget(['registro_negocio_nombre', 'registro_negocio_tipo']);
        }

        return view('payment.success');
    }

    /**
     * Página de cancelación del pago
     */
    public function cancel()
    {
        return view('payment.cancel');
    }

    /**
     * Mostrar estado de suscripción actual
     */
    public function miSuscripcion()
    {
        $suscripcion = null;

        try {
            $response = $this->httpClient->get('/api/suscripciones/mi-suscripcion');
            $suscripcion = $response['data'] ?? null;
        } catch (RuntimeException $e) {
            // no hay suscripción activa o error de API
        }

        return view('payment.mi-suscripcion', compact('suscripcion'));
    }

    /**
     * Cancelar suscripción activa
     */
    public function cancelarSuscripcion(Request $request)
    {
        try {
            $this->httpClient->post('/api/suscripciones/cancelar', []);
            return redirect()->route('payment.mi-suscripcion')
                ->with('success', 'Tu suscripción ha sido cancelada. Conservarás el acceso hasta el final del período.');
        } catch (RuntimeException $e) {
            return redirect()->route('payment.mi-suscripcion')
                ->with('error', 'No se pudo cancelar la suscripción. Inténtalo de nuevo.');
        }
    }
}
