<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class OpenAIImageService
{
    private Client $http;
    private string $apiKey;
    private string $model;

    public function __construct(?Client $client = null)
    {
        $this->http = $client ?? new Client([
            'base_uri' => rtrim(config('services.openai.base_uri', 'https://api.openai.com/v1/'), '/') . '/',
            'timeout' => 120,
        ]);
        $this->apiKey = (string) config('services.openai.key');
        $this->model = (string) config('services.openai.image_model', 'gpt-image-1');
    }

    public function generateCover(string $prompt, int $newsId, string $size = '1024x1024'): array
    {
        $response = $this->http->post('images/generations', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'prompt' => $prompt,
                'size' => $size,
                'n' => 1,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $url = $data['data'][0]['url'] ?? null;
        if (!$url) {
            return ['ok' => false, 'error' => 'No image URL returned'];
        }

        // Scarica l'immagine dall'URL
        $img = $this->http->get($url);
        $contentType = $img->getHeaderLine('Content-Type');
        $ext = str_contains($contentType, 'png') ? 'png' : 'jpg';
        $path = 'news/covers/news_' . $newsId . '_' . time() . '.' . $ext;
        Storage::disk('public')->put($path, (string) $img->getBody());

        return ['ok' => true, 'path' => $path];
    }
}


