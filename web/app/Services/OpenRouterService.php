<?php

namespace App\Services;

class OpenRouterService
{
    private string $apiKey;
    private string $baseUrl;
    private string $model;

    public function __construct()
    {
        $this->apiKey  = config('services.openrouter.api_key', '');
        $this->baseUrl = config('services.openrouter.base_url', 'https://openrouter.ai/api/v1');
        $this->model   = config('services.openrouter.model', 'openai/gpt-oss-120b:free');
    }

    public function sugerirSolucao(string $titulo, string $descricao, string $status): string
    {
        $prompt = "Você é um especialista em suporte técnico. Analise o chamado abaixo e sugira uma solução clara e objetiva em português.\n\n"
            . "**Título:** {$titulo}\n"
            . "**Descrição:** {$descricao}\n"
            . "**Status atual:** {$status}\n\n"
            . "Forneça:\n"
            . "1. Diagnóstico do problema\n"
            . "2. Passos para resolução\n"
            . "3. Previsão de complexidade (Baixa / Média / Alta)";

        $response = $this->post('/chat/completions', [
            'model'    => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $message = $response['choices'][0]['message']['content'] ?? null;

        if (is_string($message) && trim($message) !== '') {
            return $message;
        }

        if (is_array($message)) {
            $parts = [];

            foreach ($message as $part) {
                if (is_array($part) && isset($part['text']) && is_string($part['text'])) {
                    $parts[] = $part['text'];
                }
            }

            $joined = trim(implode("\n", $parts));

            if ($joined !== '') {
                return $joined;
            }
        }

        throw new \RuntimeException('A IA não retornou conteúdo de sugestão.');
    }

    private function post(string $path, array $body): array
    {
        if ($this->apiKey === '') {
            throw new \RuntimeException('OPENROUTER_API_KEY não configurada.');
        }

        $ch = curl_init($this->baseUrl . $path);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($body),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
                'HTTP-Referer: ' . config('app.url'),
                'X-Title: ' . config('app.name'),
            ],
            CURLOPT_CONNECTTIMEOUT => 3600,
            CURLOPT_TIMEOUT        => 3600,
        ]);

        $result = curl_exec($ch);
        $error  = curl_error($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("Erro ao conectar com OpenRouter: {$error}");
        }

        if (!is_string($result) || trim($result) === '') {
            throw new \RuntimeException('Resposta vazia ao consultar OpenRouter.');
        }

        $decoded = json_decode($result, true);

        if (!is_array($decoded)) {
            throw new \RuntimeException('Resposta inválida ao consultar OpenRouter.');
        }

        if ($status < 200 || $status >= 300) {
            $apiMessage = $decoded['error']['message'] ?? $decoded['message'] ?? 'Erro desconhecido da OpenRouter.';
            throw new \RuntimeException("OpenRouter retornou HTTP {$status}: {$apiMessage}");
        }

        if (isset($decoded['error'])) {
            $apiMessage = is_array($decoded['error'])
                ? ($decoded['error']['message'] ?? 'Erro desconhecido da OpenRouter.')
                : (string) $decoded['error'];

            throw new \RuntimeException("OpenRouter retornou erro: {$apiMessage}");
        }

        return $decoded;
    }
}
