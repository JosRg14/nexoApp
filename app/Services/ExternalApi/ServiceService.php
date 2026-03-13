<?php

namespace App\Services\ExternalApi;

class ServiceService
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->get('/api/servicios');
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