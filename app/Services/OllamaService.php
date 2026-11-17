<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OllamaService
{
    protected string $baseUrl;
    protected string $model;

    public function __construct()
    {
        $this->baseUrl = 'http://127.0.0.1:11434';
        $this->model = 'llama3.2:1b';
    }

    public function chat(string $prompt): string
    {
        try {
            $response = Http::timeout(120)
                ->post($this->baseUrl . '/api/chat', [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Kamu adalah AI Business Assistant Restoe Boemi, restoran di Indonesia. Jawab selalu dalam bahasa Indonesia yang natural, profesional, singkat, dan mudah dipahami. Gunakan hanya data yang diberikan. Jangan mengarang angka, transaksi, atau fakta. Jika data tidak cukup, katakan dengan jujur.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'stream' => false,
                    'options' => [
                        'temperature' => 0.3,
                        'num_predict' => 500,
                    ],
                ]);

            if ($response->failed()) {
                throw new RuntimeException(
                    'Ollama memberikan respons HTTP ' . $response->status()
                );
            }

            $answer = $response->json('message.content');

            if (!is_string($answer) || trim($answer) === '') {
                throw new RuntimeException('Jawaban AI kosong.');
            }

            return trim($answer);

        } catch (\Throwable $e) {
            Log::error('Ollama Service Error: ' . $e->getMessage());

            throw new RuntimeException(
                'AI Assistant sedang tidak dapat dihubungi. Pastikan Ollama aktif.',
                0,
                $e
            );
        }
    }
}
