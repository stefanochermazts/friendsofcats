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

    public function generateCover(string $prompt, int $newsId): array
    {
        $response = $this->http->post('images/generations', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'prompt' => $prompt,
                'size' => '1920x1080',
                'n' => 1,
                'response_format' => 'b64_json',
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $b64 = $data['data'][0]['b64_json'] ?? null;
        if (!$b64) {
            return ['ok' => false, 'error' => 'No image returned'];
        }

        $binary = base64_decode($b64);
        $path = 'news/covers/news_' . $newsId . '_' . time() . '.jpg';
        Storage::disk('public')->put($path, $binary);

        return ['ok' => true, 'path' => $path];
    }
}


