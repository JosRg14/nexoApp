<?php
namespace App\Services\ExternalApi;
use Illuminate\Support\Facades\Http;

class BusinessService
{
    protected HttpClient $client; // Tu clase personalizada

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function find($id)
    {
        // Cambiamos 'http' por 'client' y quitamos 'json()' 
        // para que use TU lógica de HttpClient
        return $this->client->get("/api/admin/negocios/{$id}");
    }

    public function updateStatus($id, $status)
    {
    $endpoint = "https://devlink-servidorapi.td60xq.easypanel.host/api/admin/negocios/{$id}/estado";

    $response = Http::withToken(session('auth_token')) // <--- IMPORTANTE: 'auth_token', no 'api_token'
        ->asJson()
        ->withoutVerifying()
        ->patch($endpoint, [
            'estado' => $status
        ]);

    return $response->json();
    }

    public function list(array $filters = []): array
    {
        return $this->client->get('/api/admin/negocios', $filters);
    }
}