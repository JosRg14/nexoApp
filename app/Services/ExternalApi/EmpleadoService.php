<?php

namespace App\Services\ExternalApi;

class EmpleadoService
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /** List all employees */
    public function list(): array
    {
        return $this->client->get('/api/empleados');
    }
}
?>
