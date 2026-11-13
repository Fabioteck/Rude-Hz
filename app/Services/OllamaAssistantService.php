<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaAssistantService
{
    protected string $baseUrl;
    protected string $model;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = env('OLLAMA_BASE_URL', 'http://192.168.178.186:11434');
        $this->model = env('OLLAMA_MODEL', 'qwen2.5-coder:1.5b');
        $this->timeout = (int) env('OLLAMA_TIMEOUT', 60);
    }

    public function chat(string $userMessage): string
    {
        $systemPrompt = "Sei Lama, assistente tecnico per produttori di musica elettronica underground. Rispondi in italiano, in modo pratico e conciso. Spiega sintetizzatori, campionatori, drum machine, sound design, mix e produzione. Non inventare specifiche hardware. Se non sei sicuro, dillo.";

        try {
            $response = Http::timeout($this->timeout)
                ->post(rtrim($this->baseUrl, '/') . '/api/chat', [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemPrompt
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'stream' => false
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['message']['content'])) {
                    return $data['message']['content'];
                }
                Log::warning('Ollama missing message.content', ['data' => $data]);
            } else {
                Log::warning('Ollama API error response', ['status' => $response->status(), 'body' => $response->body()]);
            }

            return 'Assistant temporaneamente non disponibile. Riprova più tardi.';
        } catch (\Exception $e) {
            Log::error('Ollama connection error: ' . $e->getMessage());
            return 'Assistant temporaneamente non disponibile. Riprova più tardi.';
        }
    }
}
