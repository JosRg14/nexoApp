<?php

namespace App\Services\ExternalApi;

class EmployeeService
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->get('/api/empleados');
    }

    public function create(array $data)
    {
        return $this->client->post('/api/admin/register/empleado', $data);
    }

    public function update($id, array $data)
    {
        return $this->client->put("/api/empleados/{$id}", $data);
    }

    public function delete($id)
    {
        return $this->client->delete("/api/empleados/{$id}");
    }
}