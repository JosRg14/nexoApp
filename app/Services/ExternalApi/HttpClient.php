<?php

namespace App\Services\ExternalApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class HttpClient
{
    protected string $baseUrl;
    protected ?string $token = null;
    protected int $timeout = 10; // seconds

    public function __construct()
    {
        $this->baseUrl = config('services.api.url');
    }

    /**
     * Called by middleware to inject the current session token.
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /** Build the request with common headers */
    protected function request(string $method, string $uri, array $payload = []): Response
{
    $headers = [
        'Accept' => 'application/json',
        'ngrok-skip-browser-warning' => 'true', // 🔥 evita bloqueo ngrok
        'User-Agent' => 'Mozilla/5.0', // 🔥 evita empty reply
    ];

    if ($this->token) {
        $headers['Authorization'] = "Bearer {$this->token}";
    }

    $url = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');

    $request = Http::withHeaders($headers)
        ->timeout($this->timeout)
        ->retry(2, 500); // 🔥 reintenta si ngrok corta conexión

    try {

        if ($method === 'GET') {
            return $request->get($url, $payload);
        }

        return $request->send($method, $url, [
            'json' => $payload,
        ]);

    } catch (\Exception $e) {

        Log::error('External API connection failed', [
            'url' => $url,
            'error' => $e->getMessage(),
        ]);

        throw new RuntimeException('No se pudo conectar con el servidor externo.');
    }
}

    // -----------------------------------------------------------------
    // Public helpers (GET, POST, PUT, DELETE)
    // -----------------------------------------------------------------
    public function get(string $uri, array $query = []): array
    {
        // Query parameters are passed directly to the request method
        return $this->handle($this->request('GET', $uri, $query));
    }

    public function post(string $uri, array $data = []): array
    {
        return $this->handle($this->request('POST', $uri, $data));
    }

    public function put(string $uri, array $data = []): array
    {
        return $this->handle($this->request('PUT', $uri, $data));
    }

    public function delete(string $uri, array $data = []): array
    {
        return $this->handle($this->request('DELETE', $uri, $data));
    }

    /** Uniform error handling */
    protected function handle(Response $response): array
    {
        if ($response->successful()) {
            return $response->json();
        }

        Log::warning('External API error', [
            'status' => $response->status(),
            'url'    => $response->effectiveUri(),
            'body'   => $response->body(),
        ]);

        $message = $response->json('message') ?? 'External service error';
        throw new RuntimeException($message, $response->status());
    }
}
?>
