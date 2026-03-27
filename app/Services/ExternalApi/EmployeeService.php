<?php

namespace App\Services\ExternalApi;

class EmployeeService
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function list(array $params = [])
{
    $token = session('auth_token');
    
    $url = 'https://devlink-servidorapi.td60xq.easypanel.host/api/empleados';
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