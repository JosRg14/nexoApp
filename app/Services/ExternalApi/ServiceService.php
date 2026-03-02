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
        return $this->client->post('/api/servicios', $data);
    }

    public function update(int $id, array $data): array
{
    return $this->client->put("/api/servicios/{$id}", $data);
}

public function delete(int $id): array
{
    return $this->client->delete("/api/servicios/{$id}");
}
}