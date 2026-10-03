<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Klien tipis untuk OpenRouteService Directions API (https://openrouteservice.org).
 * Mengembalikan null kalau API key belum diisi, panggilan gagal, atau timeout —
 * supaya pemanggilnya (RouteEstimator) bisa fallback ke kalkulasi sendiri
 * dan halaman tetap bisa dipakai walau tanpa koneksi ke layanan ini.
 */
class OpenRouteServiceClient
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openrouteservice.key');
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * @param  string  $profile  'driving-car' | 'cycling-regular' | 'foot-walking'
     * @return array{distance_km: float, duration_min: int}|null
     */
    public function route(float $lat1, float $lng1, float $lat2, float $lng2, string $profile = 'driving-car'): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        // Cache 7 hari: pasangan titik yang sama tidak perlu dipanggil ulang setiap kali halaman dibuka
        $cacheKey = sprintf('ors:%s:%.4f,%.4f-%.4f,%.4f', $profile, $lat1, $lng1, $lat2, $lng2);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($lat1, $lng1, $lat2, $lng2, $profile) {
            try {
                $response = Http::timeout(8)->get("https://api.openrouteservice.org/v2/directions/{$profile}", [
                    'api_key' => $this->apiKey,
                    // ORS memakai urutan lng,lat (bukan lat,lng)
                    'start' => "{$lng1},{$lat1}",
                    'end' => "{$lng2},{$lat2}",
                ]);

                if (! $response->successful()) {
                    Log::warning('OpenRouteService gagal: ' . $response->status() . ' ' . $response->body());

                    return null;
                }

                $segment = $response->json('features.0.properties.segments.0');
                if (! $segment) {
                    return null;
                }

                return [
                    'distance_km' => $segment['distance'] / 1000,
                    'duration_min' => (int) round($segment['duration'] / 60),
                ];
            } catch (\Throwable $e) {
                Log::warning('OpenRouteService error: ' . $e->getMessage());

                return null;
            }
        });
    }
}
