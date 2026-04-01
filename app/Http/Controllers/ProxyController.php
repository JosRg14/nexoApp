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
        // En nuestro caso el prefijo 'public' podría o no ser parte de la URL real,
        // asumo que lo agregaremos al endpoint como /api/{endpoint}.
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
        $path = ltrim($endpoint, '/');
        if (str_starts_with($path, 'storage/')) {
            $url = rtrim(config('services.api.url'), '/') . '/' . $path;
        } else {
            $url = rtrim(config('services.api.url'), '/') . '/api/' . ltrim(preg_replace('/^api\//', '', $path), '/');
        }

        
        // method() ya evalúa si la request vino con _method=PUT o _method=DELETE
        $method = strtolower($request->method());

        $headers = [
            'Accept' => 'application/json',
            'ngrok-skip-browser-warning' => 'true',
            'User-Agent' => 'Mozilla/5.0',
        ];

        if ($token) {
            $headers['Authorization'] = "Bearer {$token}";
        }

        $pendingRequest = Http::withHeaders($headers)
            ->withOptions(['verify' => false])
            ->timeout(15)
            ->retry(2, 500);


        $hasFiles = !empty($request->allFiles());

        // Manejo de Multipart/File attachments
        if ($hasFiles) {
            foreach ($request->allFiles() as $key => $file) {
                $files = is_array($file) ? $file : [$file];

                foreach ($files as $index => $f) {
                    $realPath = $f->getRealPath();

                    Log::info('Procesando archivo:', [
                        'key'      => $key,
                        'name'     => $f->getClientOriginalName(),
                        'size'     => $f->getSize(),
                        'mime'     => $f->getMimeType(),
                        'realPath' => $realPath,
                        'is_file'  => is_file($realPath),
                        'is_dir'   => is_dir($realPath),
                        'exists'   => file_exists($realPath),
                    ]);

                    // Sólo adjuntar si la ruta apunta a un archivo real (no a un directorio)
                    if (!is_file($realPath)) {
                        Log::error("Archivo inválido omitido: '{$key}' → {$realPath} (no es un archivo)");
                        continue;
                    }

                    $fieldName = is_array($file) ? "{$key}[{$index}]" : $key;
                    $pendingRequest = $pendingRequest->attach(
                        $fieldName,
                        file_get_contents($realPath),
                        $f->getClientOriginalName(),
                        ['Content-Type' => $f->getMimeType()]
                    );
                }
            }
        }

        Log::info("Proxy enviando a: {$url}", [
            'method'   => strtoupper($method),
            'hasFiles' => $hasFiles,
            'fields'   => array_keys($request->except(['_token', '_method'])),
        ]);

        try {
            // Excluir tokens de Laravel Y los objetos UploadedFile del body de texto
            // (los archivos ya fueron adjuntados vía ->attach() arriba)
            $fileKeys = array_keys($request->allFiles());
            $data = $request->except(array_merge(['_token', '_method'], $fileKeys));

            if ($method === 'get' || $method === 'head') {
                // En GET/HEAD, los datos viajan como query params
                $response = $pendingRequest->$method($url, $request->query());
            } elseif ($hasFiles) {
                // ⚠️ CRÍTICO: Cuando hay archivos, NUNCA usar PUT/PATCH directamente.
                // Guzzle los enviaría como JSON y perdería todos los adjuntos.
                // Solución: POST + _method spoofing (igual que HttpClient::putMultipart)
                if ($method === 'put' || $method === 'patch') {
                    $data['_method'] = strtoupper($method);
                }
                $response = $pendingRequest->post($url, $data);
            } else {
                $pendingRequest->asJson();
                $response = $pendingRequest->$method($url, $data);
            }

            if ($response->status() >= 400) {
                Log::warning('Proxy request error', [
                    'url'      => $url,
                    'method'   => strtoupper($method),
                    'status'   => $response->status(),
                    'response' => $response->body(),
                ]);
            }

            // Devolver la respuesta transparente, útil para JSON y para Imágenes/Binarios
            return response($response->body(), $response->status(), [
                'Content-Type' => $response->header('Content-Type') ?? 'application/json'
            ]);

        } catch (\Exception $e) {
            Log::error('Proxy connection failure', [
                'url'   => $url,
                'error' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Error interno conectando con el servicio.'], 500);
        }
    }
}
