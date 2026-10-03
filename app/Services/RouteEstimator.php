<?php

namespace App\Services;

/**
 * Menghitung estimasi rute (jarak, waktu, biaya) antar titik.
 *
 * - Mobil & Motor: mencoba memakai rute jalan sungguhan dari OpenRouteService
 *   (lihat OpenRouteServiceClient). Motor memakai profil mobil sebagai dasar
 *   (OpenRouteService tidak punya profil khusus motor) lalu durasinya
 *   dikalikan 0.8 untuk mendekati kenyataan bahwa motor lebih gesit di
 *   kemacetan — ini tetap pendekatan, bukan data motor sungguhan.
 * - Kalau OpenRouteService tidak dikonfigurasi atau panggilannya gagal,
 *   otomatis fallback ke kalkulasi jarak garis lurus (haversine) + asumsi
 *   kecepatan, supaya halaman tetap berfungsi.
 * - Transportasi Umum SELALU memakai kalkulasi sendiri (garis lurus +
 *   asumsi kecepatan/tarif), karena OpenRouteService tidak mendukung rute
 *   angkutan umum sama sekali.
 */
class RouteEstimator
{
    public const MODES = ['umum', 'motor', 'mobil'];

    public function __construct(protected OpenRouteServiceClient $ors)
    {
    }

    /**
     * @param  array{lat: float, lng: float, name: string}  $origin
     * @param  \Illuminate\Support\Collection<int, \App\Models\Place>  $places  Urutan destinasi
     * @param  string  $mode  'umum' | 'motor' | 'mobil'
     * @return array{legs: array, subtotal: int, extra: int, total: int, used_real_routing: bool}
     */
    public function estimate(array $origin, $places, string $mode): array
    {
        $legs = [];
        $clockMinutes = 9 * 60; // asumsi mulai jam 09:00
        $subtotal = 0;
        $extra = 0;
        $usedRealRouting = false;

        $prevLat = $origin['lat'];
        $prevLng = $origin['lng'];

        $legs[] = [
            'time' => $this->formatClock($clockMinutes),
            'title' => $origin['name'],
            'subtitle' => 'Titik Keberangkatan Awal',
            'travel' => null,
        ];

        foreach ($places as $place) {
            $hasCoords = ! is_null($place->lat) && ! is_null($place->lng);
            $lat = $hasCoords ? (float) $place->lat : $prevLat;
            $lng = $hasCoords ? (float) $place->lng : $prevLng;

            $travel = $this->travelFor($mode, $prevLat, $prevLng, $lat, $lng, $place->name, $hasCoords);
            if ($travel['is_real_routing']) {
                $usedRealRouting = true;
            }

            $subtotal += $travel['primary_cost'];
            $extra += $travel['extra_cost'];
            $clockMinutes += $travel['duration_min'];

            $legs[] = [
                'time' => $this->formatClock($clockMinutes),
                'title' => $place->name,
                'subtitle' => $place->activity_tag ?? 'Eksplorasi',
                'travel' => $travel,
            ];

            $visitAvg = (int) round((($place->visit_duration_min ?? 30) + ($place->visit_duration_max ?? 45)) / 2);
            $clockMinutes += $visitAvg;

            $prevLat = $lat;
            $prevLng = $lng;
        }

        return [
            'legs' => $legs,
            'subtotal' => $subtotal,
            'extra' => $extra,
            'total' => $subtotal + $extra,
            'used_real_routing' => $usedRealRouting,
        ];
    }

    /** Perkiraan kasar total durasi trip (dipakai di layar "Titik Awal" sebelum pilih moda) */
    public function roughDurationRange(array $origin, $places): string
    {
        $totalMinutes = 0;
        $prevLat = $origin['lat'];
        $prevLng = $origin['lng'];

        foreach ($places as $place) {
            if (! is_null($place->lat) && ! is_null($place->lng)) {
                $distanceKm = $this->haversineKm($prevLat, $prevLng, (float) $place->lat, (float) $place->lng);
                $totalMinutes += max(10, (int) round($distanceKm / 22 * 60));
                $prevLat = (float) $place->lat;
                $prevLng = (float) $place->lng;
            } else {
                $totalMinutes += 20;
            }

            $totalMinutes += (int) round((($place->visit_duration_min ?? 30) + ($place->visit_duration_max ?? 45)) / 2);
        }

        $lowHour = max(1, (int) floor($totalMinutes / 60));
        $highHour = $lowHour + 1;

        return "~{$lowHour}-{$highHour} Jam Perjalanan";
    }

    protected function travelFor(string $mode, float $prevLat, float $prevLng, float $lat, float $lng, string $destinationName, bool $hasCoords): array
    {
        return match ($mode) {
            'mobil' => $this->carEstimate($prevLat, $prevLng, $lat, $lng, $destinationName, $hasCoords),
            'motor' => $this->motorbikeEstimate($prevLat, $prevLng, $lat, $lng, $destinationName, $hasCoords),
            default => $this->publicTransitEstimate($this->haversineKm($prevLat, $prevLng, $lat, $lng), $destinationName),
        };
    }

    protected function carEstimate(float $prevLat, float $prevLng, float $lat, float $lng, string $destination, bool $hasCoords): array
    {
        $routed = $hasCoords ? $this->ors->route($prevLat, $prevLng, $lat, $lng, 'driving-car') : null;

        $km = $routed['distance_km'] ?? $this->haversineKm($prevLat, $prevLng, $lat, $lng);
        $durationMin = $routed['duration_min'] ?? max(10, (int) round($km / 20 * 60 / 5) * 5);

        $bbm = (int) round($km * 800, -2);
        $toll = $km > 3 ? 10500 : 0;
        $parkir = 4000;

        return [
            'mode' => 'mobil',
            'description' => $routed
                ? "Rute jalan tercepat menuju {$destination} (±" . round($km, 1) . " km)."
                : "Perjalanan mobil menuju {$destination}, estimasi jarak garis lurus (±" . round($km, 1) . " km).",
            'duration_min' => $durationMin,
            'breakdown' => array_filter([
                $toll > 0 ? 'Tol Rp' . number_format($toll, 0, ',', '.') : null,
                'BBM Rp' . number_format($bbm, 0, ',', '.'),
                'Parkir Rp' . number_format($parkir, 0, ',', '.'),
            ]),
            'primary_cost' => $bbm,
            'extra_cost' => $toll + $parkir,
            'is_real_routing' => (bool) $routed,
        ];
    }

    protected function motorbikeEstimate(float $prevLat, float $prevLng, float $lat, float $lng, string $destination, bool $hasCoords): array
    {
        // Tidak ada profil "motor" di OpenRouteService — pinjam rute mobil,
        // lalu percepat durasinya (motor biasanya lebih gesit di kemacetan).
        $routed = $hasCoords ? $this->ors->route($prevLat, $prevLng, $lat, $lng, 'driving-car') : null;

        $km = $routed['distance_km'] ?? $this->haversineKm($prevLat, $prevLng, $lat, $lng);
        $durationMin = $routed
            ? max(5, (int) round($routed['duration_min'] * 0.8))
            : max(10, (int) round($km / 25 * 60 / 5) * 5);

        $bensin = (int) round($km * 430, -2);
        $parkir = 4000;

        return [
            'mode' => 'motor',
            'description' => $routed
                ? "Rute jalan tercepat menuju {$destination} (±" . round($km, 1) . " km)."
                : "Perjalanan motor menuju {$destination}, estimasi jarak garis lurus (±" . round($km, 1) . " km).",
            'duration_min' => $durationMin,
            'breakdown' => [
                'Bensin Rp' . number_format($bensin, 0, ',', '.'),
                'Parkir Rp' . number_format($parkir, 0, ',', '.'),
            ],
            'primary_cost' => $bensin,
            'extra_cost' => $parkir,
            'is_real_routing' => (bool) $routed,
        ];
    }

    protected function publicTransitEstimate(float $km, string $destination): array
    {
        $durationMin = max(15, (int) round($km / 16 * 60 / 5) * 5);

        if ($km <= 6) {
            $fare = 3500;
            $desc = "Naik TransJakarta menuju {$destination}.";
        } else {
            $fare = min(14000, (int) round(3000 + 700 * $km, -2));
            $needsTransfer = $km > 10;
            $fare += $needsTransfer ? 3500 : 0;
            $desc = $needsTransfer
                ? "Naik MRT lalu lanjut TransJakarta menuju {$destination}."
                : "Naik MRT menuju {$destination}.";
        }

        return [
            'mode' => 'umum',
            'description' => $desc . ' (estimasi jarak garis lurus, ±' . round($km, 1) . ' km — bukan data rute transit sungguhan)',
            'duration_min' => $durationMin,
            'breakdown' => ['Rp' . number_format($fare, 0, ',', '.')],
            'primary_cost' => $fare,
            'extra_cost' => 0,
            'is_real_routing' => false,
        ];
    }

    protected function haversineKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadiusKm = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadiusKm * $c;
    }

    protected function formatClock(int $totalMinutes): string
    {
        $h24 = intdiv($totalMinutes, 60) % 24;
        $m = $totalMinutes % 60;
        $suffix = $h24 >= 12 ? 'PM' : 'AM';
        $h12 = $h24 % 12 === 0 ? 12 : $h24 % 12;

        return sprintf('%02d:%02d %s', $h12, $m, $suffix);
    }
}
