<?php

namespace Mayanksinh\OpenAI;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class OpenAI
{
    protected Client $client;
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('openai.api_key');
        $this->model = config('openai.model', 'gpt-4');
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'timeout' => 15,
        ]);
    }

    public function generateText(string $prompt, int $maxTokens = 500): string
    {
        $cacheKey = md5("text-$prompt-$maxTokens");

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($prompt, $maxTokens) {
            $response = $this->client->post('chat/completions', [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => $maxTokens,
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            return $result['choices'][0]['message']['content'] ?? '';
        });
    }

    public function generateImage(string $prompt, int $imageCount = 1, string $size = '1024x1024'): array
    {
        $response = $this->client->post('images/generations', [
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'prompt' => $prompt,
                'n' => $imageCount,
                'size' => $size,
                'response_format' => 'url'
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        return collect($result['data'])->pluck('url')->toArray();
    }
}
