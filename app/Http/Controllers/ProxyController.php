<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProxyController extends Controller
{
    /**
     * Proxy Público sin protección de sesión
     */
    public function handlePublic(Request $request, $endpoint)
    {
        return $this->forwardRequest($request, $endpoint, null);
    }

    /**
     * Proxy Protegido (Requiere auth_token)
     */
    public function handle(Request $request, $endpoint)
    {
        if (!session()->has('auth_token')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return $this->forwardRequest($request, $endpoint, session('auth_token'));
    }

    /**
     * Reenvío genérico de la petición.
     */
    protected function forwardRequest(Request $request, $endpoint, $token = null)
    {
        // --- Construir URL destino ---
        $path = ltrim($endpoint, '/');
        if (str_starts_with($path, 'storage/')) {
            $url = rtrim(config('services.api.url'), '/') . '/' . $path;
        } else {
            $url = rtrim(config('services.api.url'), '/') . '/api/' . ltrim(preg_replace('/^api\//', '', $path), '/');
        }

        // El método puede haber sido spoofado con _method (PUT, PATCH, DELETE)
        $method = strtolower($request->method());

        // --- Headers base ---
        $headers = [
            'Accept'                     => 'application/json',
            'ngrok-skip-browser-warning' => 'true',
            'User-Agent'                 => 'Mozilla/5.0',
        ];

        if ($token) {
            $headers['Authorization'] = "Bearer {$token}";
        }

        // --- Detectar archivos ---
        $hasFiles = count($request->allFiles()) > 0;

        Log::info("Proxy → {$url}", [
            'method'   => strtoupper($method),
            'hasFiles' => $hasFiles,
            'fields'   => array_keys($request->except(['_token', '_method'])),
        ]);

        try {
            // ============================================================
            // RUTA A: Con archivos → multipart
            // ============================================================
            if ($hasFiles) {

                // Guzzle no puede mezclar ->attach() con HTTP PUT/PATCH real.
                // Solución: convertir a POST + _method spoofing en el body.
                $sendMethod = in_array($method, ['put', 'patch']) ? 'post' : $method;

                // Datos de texto: excluir tokens Y claves de archivo
                // (los archivos van por ->attach(), no en el body)
                $fileKeys = array_keys($request->allFiles());
                $textData = $request->except(array_merge(['_token', '_method'], $fileKeys));

                if ($sendMethod !== $method) {
                    $textData['_method'] = strtoupper($method);
                }

                // Construir request base
                $pendingRequest = Http::withHeaders($headers)
                    ->withOptions(['verify' => false])
                    ->timeout(30);

                // Adjuntar cada archivo con fopen (evita cargar en memoria)
                foreach ($request->allFiles() as $key => $file) {
                    $items = is_array($file) ? $file : [$file];

                    foreach ($items as $index => $f) {
                        /** @var \Illuminate\Http\UploadedFile $f */
                        if (!($f instanceof \Illuminate\Http\UploadedFile) || !$f->isValid()) {
                            Log::warning('Proxy: archivo omitido (inválido)', [
                                'key'   => $key,
                                'error' => $f instanceof \Illuminate\Http\UploadedFile
                                    ? $f->getErrorMessage()
                                    : 'no es UploadedFile',
                            ]);
                            continue;
                        }

                        $realPath  = $f->getRealPath();
                        $fieldName = is_array($file) ? "{$key}[{$index}]" : $key;

                        Log::info('Proxy: adjuntando archivo', [
                            'field'   => $fieldName,
                            'name'    => $f->getClientOriginalName(),
                            'size'    => $f->getSize(),
                            'mime'    => $f->getMimeType(),
                            'is_file' => is_file($realPath),
                        ]);

                        $pendingRequest = $pendingRequest->attach(
                            $fieldName,
                            fopen($realPath, 'r'),
                            $f->getClientOriginalName(),
                            ['Content-Type' => $f->getMimeType()]
                        );
                    }
                }

                $response = $pendingRequest->{$sendMethod}($url, $textData);

            // ============================================================
            // RUTA B: Sin archivos → JSON o query params
            // ============================================================
            } else {
                $data = $request->except(['_token', '_method']);

                $pendingRequest = Http::withHeaders($headers)
                    ->withOptions(['verify' => false])
                    ->timeout(15)
                    ->retry(2, 500);

                if ($method === 'get' || $method === 'head') {
                    $response = $pendingRequest->{$method}($url, $request->query());
                } else {
                    $response = $pendingRequest->asJson()->{$method}($url, $data);
                }
            }

            if ($response->status() >= 400) {
                Log::warning('Proxy: respuesta de error', [
                    'url'      => $url,
                    'method'   => strtoupper($method),
                    'status'   => $response->status(),
                    'response' => $response->body(),
                ]);
            }

            // Respuesta transparente (JSON, imágenes, binarios, etc.)
            return response($response->body(), $response->status(), [
                'Content-Type' => $response->header('Content-Type') ?? 'application/json',
            ]);

        } catch (\Exception $e) {
            Log::error('Proxy: fallo de conexión', [
                'url'   => $url,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Error interno conectando con el servicio.'], 500);
        }
    }
}
