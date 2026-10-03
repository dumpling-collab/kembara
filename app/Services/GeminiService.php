<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Memakai Google Gemini (free tier) untuk MEMILIH & MENGURUTKAN tempat yang
 * sudah ada di database kita — bukan untuk mengarang tempat baru. Ini sengaja
 * dibatasi begitu supaya AI tidak berisiko berhalusinasi soal fakta tempat
 * sungguhan; AI hanya bertugas kurasi + menulis alasan singkat.
 *
 * Kembali null kalau API key belum diisi atau panggilannya gagal, supaya
 * pemanggilnya bisa fallback ke logika biasa (urut rating).
 */
class GeminiService
{
    protected ?string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model', 'gemini-3.8-flash');
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * @param  Collection<int, \App\Models\Place>  $candidates  Tempat yang boleh dipilih AI
     * @param  int  $count  Berapa tempat yang mau direkomendasikan
     * @return array<int, array{id: int, reason: string}>|null  null kalau gagal
     */
    public function recommend(Collection $candidates, int $count = 3): ?array
    {
        if (! $this->isConfigured() || $candidates->isEmpty()) {
            return null;
        }

        $catalog = $candidates->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'category' => $p->category->value,
            'district' => $p->district,
            'rating' => (float) $p->rating,
            'summary' => $p->explore_summary ?? $p->description ?? $p->badge,
        ])->values()->all();

        $prompt = <<<PROMPT
            Kamu adalah kurator rekomendasi wisata untuk aplikasi "Kembara" di Jakarta.
            Dari daftar tempat JSON di bawah ini (dan HANYA dari daftar ini, jangan
            menyebut tempat lain di luar daftar), pilih {$count} tempat terbaik untuk
            direkomendasikan sebagai "Tempat Hits" hari ini. Usahakan variasi kategori
            atau wilayah supaya tidak monoton.

            Daftar tempat:
            {$this->toJson($catalog)}

            Balas HANYA dengan JSON array, tanpa teks lain, tanpa markdown code fence,
            persis format berikut:
            [{"id": 123, "reason": "alasan singkat satu kalimat dalam Bahasa Indonesia"}]
            PROMPT;

        try {
            $modelsToTry = array_values(array_unique(array_filter([
                $this->model,
                'gemini-3.8-flash',
                'gemini-2.5-flash',
            ])));

            foreach ($modelsToTry as $model) {
                $response = Http::timeout(15)->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}",
                    [
                        'contents' => [['parts' => [['text' => $prompt]]]],
                        'generationConfig' => ['temperature' => 0.7],
                    ]
                );

                if ($response->successful()) {
                    $this->model = $model;

                    $text = $response->json('candidates.0.content.parts.0.text');
                    $text = trim(preg_replace('/^```json|```$/m', '', $text ?? ''));

                    $parsed = json_decode($text, true);
                    if (! is_array($parsed)) {
                        return null;
                    }

                    // Validasi: cuma terima id yang memang ada di daftar kandidat (anti-halusinasi)
                    $validIds = $candidates->pluck('id')->all();
                    $result = collect($parsed)
                        ->filter(fn ($item) => isset($item['id']) && in_array($item['id'], $validIds, true))
                        ->map(fn ($item) => ['id' => (int) $item['id'], 'reason' => (string) ($item['reason'] ?? '')])
                        ->values()
                        ->all();

                    return count($result) > 0 ? $result : null;
                }

                if ($response->status() === 404 && $model !== 'gemini-3.8-flash') {
                    continue;
                }

                Log::warning('Gemini gagal: ' . $response->status() . ' ' . $response->body());

                return null;
            }

            return null;
        } catch (\Throwable $e) {
            Log::warning('Gemini error: ' . $e->getMessage());

            return null;
        }
    }

    protected function toJson(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
