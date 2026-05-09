<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class VideoController extends Controller
{
    protected string $apiBase;

    public function __construct()
    {
        $this->apiBase = rtrim(config('services.api.url'), '/');
    }

    // ─────────────────────────────────────────────
    // Vista principal de videos
    // ─────────────────────────────────────────────
    public function index()
    {
        return view('videos.index');
    }

    // ─────────────────────────────────────────────
    // POST /api-proxy/videos  →  Subir video
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        ini_set('upload_max_filesize', '0');
        ini_set('post_max_size', '0');
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');

        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'video'       => 'required|file|mimes:mp4,mov,avi,webm|max:512000', // 500 MB
        ]);

        $token = session('auth_token');
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $file = $request->file('video');

        try {
            Log::info('BFF VideoController - Iniciando subida', [
                'url'       => "{$this->apiBase}/api/videos",
                'titulo'    => $request->titulo,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);

            $requestData = ['titulo' => $request->titulo];
            if ($request->filled('descripcion')) {
                $requestData['descripcion'] = $request->descripcion;
            }

            $response = \Illuminate\Support\Facades\Http::withToken($token)
                ->withOptions(['verify' => false])
                ->timeout(300)
                ->attach(
                    'video',
                    fopen($file->getRealPath(), 'r'),
                    $file->getClientOriginalName()
                )
                ->post("{$this->apiBase}/api/videos", $requestData);

            Log::info('BFF VideoController@store - Respuesta', [
                'url' => "{$this->apiBase}/api/videos",
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'response_status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            $body = $response->json();
            
            if (!$response->successful() && !$body) {
                return response($response->body(), $response->status())->header('Content-Type', 'text/html');
            }

            return response()->json($body ?? ['success' => true], $response->status());

        } catch (\Exception $e) {
            Log::error('VideoController@store - error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error inesperado al subir el video: ' . $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // POST /api-proxy/videos/chunk  →  Subir video por chunks
    // ─────────────────────────────────────────────
    public function storeChunk(Request $request)
    {
        $chunkIndex = $request->chunk_index;
        $totalChunks = $request->total_chunks;
        $fileName = $request->file_name;
        $tempDir = storage_path('app/temp/' . session()->getId());
        
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        
        // Guardar chunk
        $request->file('video')->move($tempDir, "chunk_{$chunkIndex}");
        
        // Si es el último chunk, unir todos
        if ($chunkIndex == $totalChunks - 1) {
            $publicVideosDir = storage_path('app/public/videos');
            if (!file_exists($publicVideosDir)) {
                mkdir($publicVideosDir, 0777, true);
            }
            
            $finalPath = $publicVideosDir . '/' . $fileName;
            $finalFile = fopen($finalPath, 'wb');
            
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkPath = "{$tempDir}/chunk_{$i}";
                if (file_exists($chunkPath)) {
                    $chunk = file_get_contents($chunkPath);
                    fwrite($finalFile, $chunk);
                    unlink($chunkPath);
                }
            }
            
            fclose($finalFile);
            @rmdir($tempDir);
            
            // Enviar archivo completo a la API
            $response = \Illuminate\Support\Facades\Http::withToken(session('auth_token'))
                ->withOptions(['verify' => false])
                ->timeout(300)
                ->attach('video', fopen($finalPath, 'r'), $fileName)
                ->post("{$this->apiBase}/api/videos", [
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                ]);
            
            // Limpiar archivo temporal
            unlink($finalPath);
            
            return response()->json($response->json());
        }
        
        return response()->json(['success' => true, 'chunk' => $chunkIndex]);
    }

    // ─────────────────────────────────────────────
    // DELETE /api-proxy/videos/{id}  →  Eliminar video
    // ─────────────────────────────────────────────
    public function destroy($id)
    {
        $token = session('auth_token');
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        try {
            $guzzle = new GuzzleClient([
                'verify'  => false,
                'timeout' => 30,
            ]);

            $response = $guzzle->delete("{$this->apiBase}/api/videos/{$id}", [
                'headers' => [
                    'Authorization'              => "Bearer {$token}",
                    'Accept'                     => 'application/json',
                    'ngrok-skip-browser-warning' => 'true',
                    'User-Agent'                 => 'Mozilla/5.0',
                ],
            ]);

            $body       = json_decode($response->getBody()->getContents(), true);
            $statusCode = $response->getStatusCode();

            return response()->json($body ?? ['success' => true], $statusCode);

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body       = $e->hasResponse()
                ? json_decode($e->getResponse()->getBody()->getContents(), true)
                : null;

            Log::error("VideoController@destroy({$id}) - error", [
                'status'  => $statusCode,
                'message' => $e->getMessage(),
            ]);

            return response()->json(
                $body ?? ['success' => false, 'message' => 'Error al eliminar el video'],
                $statusCode
            );
        } catch (\Exception $e) {
            Log::error("VideoController@destroy({$id}) - unexpected: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error inesperado'], 500);
        }
    }
}
