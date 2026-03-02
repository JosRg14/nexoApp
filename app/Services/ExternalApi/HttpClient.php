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
        $this->baseUrl = config('services.nexoapi.base_url');
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
    ];

    if ($this->token) {
        $headers['Authorization'] = "Bearer {$this->token}";
    }

    $request = Http::withHeaders($headers)
    ->timeout($this->timeout);

    $url = $this->baseUrl . $uri;

    if ($method === 'GET') {
        return $request->get($url, $payload);
    }

    return $request->send($method, $url, [
        'json' => $payload,
    ]);
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
