<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function generateFromText(string $prompt): array
    {
        $apiKey = env('GEMINI_API_KEY');

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

        $payload = [
            'contents' => [[
                'parts' => [
                    ['text' => $prompt]
                ]
            ]]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        if ($response->successful()) {
            $text = $response->json('candidates.0.content.parts.0.text');

            // Nettoyage du texte retourné
            $clean = trim($text, "\" \n\r\t");
            $clean = preg_replace('/^```json|```$/m', '', $clean);
            $clean = trim($clean);

            // Log de debug
            logger()->info('💡 Gemini cleaned response:', ['raw' => $text, 'cleaned' => $clean]);

            try {
                $parsed = json_decode($clean, true);
                return is_array($parsed) ? $parsed : ['caption' => '', 'hashtags' => ''];
            } catch (\Exception $e) {
                logger()->error('❌ Parsing error from Gemini:', ['error' => $e->getMessage()]);
                return ['caption' => '', 'hashtags' => ''];
            }
        }

        // Log erreur si appel échoue
        logger()->error('❌ Gemini API request failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return ['caption' => '', 'hashtags' => ''];
    }
}
