<?php

namespace App\Services\ExternalApi;

class AuthService
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function login(array $credentials): array
    {
        return $this->client->post('/api/login', $credentials);
    }

    public function logout(): array
    {
        return $this->client->post('/api/logout');
    }

    public function me(): array
    {
        return $this->client->get('/api/me');
    }

    

}
?>
