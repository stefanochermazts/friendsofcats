<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class OpenAITranslator
{
    private Client $http;
    private string $apiKey;
    private string $model;

    public function __construct(?Client $client = null)
    {
        $this->http = $client ?? new Client([
            'base_uri' => rtrim(config('services.openai.base_uri', 'https://api.openai.com/v1/'), '/') . '/',
            'timeout' => 60,
        ]);
        $this->apiKey = (string) config('services.openai.key');
        $this->model = (string) config('services.openai.model', 'gpt-4o-mini');
    }

    public function translate(string $text, string $sourceLocale, string $targetLocale): string
    {
        if ($sourceLocale === $targetLocale) {
            return $text;
        }

        $prompt = "Traduce il seguente contenuto dal {$sourceLocale} al {$targetLocale}. Mantieni il markup HTML intatto e traduci solo il testo visibile.\n\n" . $text;

        $response = $this->http->post('chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Sei un traduttore professionista. Rispondi solo con il contenuto tradotto, senza testo aggiuntivo.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.2,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $content = $data['choices'][0]['message']['content'] ?? '';
        // Rimuovi eventuali code-fences ``` e tag lingua
        if (is_string($content)) {
            $content = $this->stripCodeFences($content);
        }
        // Alcuni modelli possono restituire strutture JSON: normalizziamo a stringa
        if (is_array($content)) {
            // Usa 'text' o 'content' se presenti, altrimenti concatena
            if (isset($content['text'])) {
                $content = (string) $content['text'];
            } elseif (isset($content['content'])) {
                $content = (string) $content['content'];
            } else {
                $content = trim(collect($content)->flatten()->join(' '));
            }
        }
        return (string) $content;
    }

    public function generateArticle(string $prompt, string $locale): array
    {
        $system = 'Sei un redattore professionista. Genera un articolo in HTML semantico (h1-h3, p, ul/ol, a, strong/em) con i seguenti campi JSON: {"title": string, "excerpt": string, "body_html": string, "meta_title": string, "meta_description": string}. Rispetta la lingua richiesta. Restituisci SOLO JSON valido.';

        $response = $this->http->post('chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => "Lingua: {$locale}. Prompt: {$prompt}"],
                ],
                'temperature' => 0.7,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $content = $data['choices'][0]['message']['content'] ?? '';
        // Prova a estrarre JSON anche se avvolto da code-fences o testo extra
        if (is_string($content)) {
            $content = $this->stripCodeFences($content);
            $json = $this->tryParseJson($content);
            if (is_array($json)) {
                return ['ok' => true, 'article' => $json, 'raw' => $content];
            }
        } elseif (is_array($content)) {
            // Alcuni modelli tornano direttamente una struttura
            $flatJson = $this->tryParseJson(json_encode($content));
            if (is_array($flatJson)) {
                return ['ok' => true, 'article' => $flatJson, 'raw' => json_encode($content)];
            }
        }
        // Fallback non valido: segnala errore e passa raw
        return ['ok' => false, 'article' => [], 'raw' => is_string($content) ? $content : json_encode($content)];
    }

    private function stripCodeFences(string $text): string
    {
        // Rimuove blocchi tipo ```json ... ``` o ``` ... ```
        $text = trim($text);
        if (preg_match('/^```[a-zA-Z0-9_-]*\n([\s\S]*?)\n```$/', $text, $m)) {
            return trim($m[1]);
        }
        // Rimuove eventuali prefissi come "json\n{...}" o simili
        if (preg_match('/^json\s*\n([\s\S]*)$/i', $text, $m)) {
            return trim($m[1]);
        }
        return $text;
    }

    private function tryParseJson(string $text): ?array
    {
        // Prova validazione diretta
        if (function_exists('json_validate') && json_validate($text)) {
            $decoded = json_decode($text, true);
            return is_array($decoded) ? $decoded : null;
        }
        // Estrai la prima coppia graffa-bilanciata
        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $candidate = substr($text, $start, $end - $start + 1);
            $decoded = json_decode($candidate, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        return null;
    }
}


