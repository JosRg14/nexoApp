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
            $guzzle = new GuzzleClient([
                'verify'  => false,
                'timeout' => 300, // 5 min para videos grandes
            ]);

            $multipart = [
                [
                    'name'     => 'titulo',
                    'contents' => $request->input('titulo'),
                ],
                [
                    'name'     => 'video',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                    'headers'  => ['Content-Type' => $file->getMimeType()],
                ],
            ];

            if ($request->filled('descripcion')) {
                $multipart[] = [
                    'name'     => 'descripcion',
                    'contents' => $request->input('descripcion'),
                ];
            }

            $response = $guzzle->post("{$this->apiBase}/api/videos", [
                'headers'   => [
                    'Authorization'              => "Bearer {$token}",
                    'Accept'                     => 'application/json',
                    'ngrok-skip-browser-warning' => 'true',
                    'User-Agent'                 => 'Mozilla/5.0',
                ],
                'multipart' => $multipart,
            ]);

            $rawBody    = $response->getBody()->getContents();
            $body       = json_decode($rawBody, true);
            $statusCode = $response->getStatusCode();

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('VideoController@store - API devolvió HTML o respuesta no JSON', [
                    'status' => $statusCode,
                    'body_preview' => substr($rawBody, 0, 500)
                ]);
                return response($rawBody, $statusCode)->header('Content-Type', 'text/html');
            }

            return response()->json($body, $statusCode);

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body       = $e->hasResponse()
                ? json_decode($e->getResponse()->getBody()->getContents(), true)
                : null;

            Log::error('VideoController@store - error', [
                'status'  => $statusCode,
                'message' => $e->getMessage(),
            ]);

            return response()->json(
                $body ?? ['success' => false, 'message' => 'Error al subir el video'],
                $statusCode
            );
        } catch (\Exception $e) {
            Log::error('VideoController@store - unexpected error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error inesperado al subir el video'], 500);
        }
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
