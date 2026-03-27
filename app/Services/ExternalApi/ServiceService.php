<?php

namespace App\Services\ExternalApi;

class ServiceService
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function list(array $params = []): array
{
    $token = session('auth_token');
    
    // Construir URL con query string
    $url = 'https://devlink-servidorapi.td60xq.easypanel.host/api/servicios';
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true) ?? [];
}

    public function create(array $data): array
    {
        if (isset($data['imagen'])) {
            return $this->client->postMultipart('/api/servicios', $data);
        }

        return $this->client->post('/api/servicios', $data);
    }

    public function update(int $id, array $data): array
    {
        if (isset($data['imagen'])) {
            return $this->client->putMultipart("/api/servicios/{$id}", $data);
        }

        return $this->client->put("/api/servicios/{$id}", $data);
    }

    public function delete(int $id): array
    {
        return $this->client->delete("/api/servicios/{$id}");
    }

    public function getByBusiness(): array
    {
        return $this->client->get('/api/servicios');
    }

    public function getBusiness()
    {
        return $this->client->get('/api/negocios/mi-negocio');
    }

    public function updateBusiness($data)
    {
        return $this->client->put('/api/negocios/mi-negocio', $data);
    }
}