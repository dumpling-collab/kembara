<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

/**
 * Koordinat (lat/lng) dan estimasi durasi kunjungan untuk tiap tempat.
 * Dipakai oleh RouteEstimator untuk menghitung jarak & waktu tempuh.
 *
 * PENTING: koordinat di bawah adalah perkiraan (dari pengetahuan umum lokasi
 * landmark Jakarta), bukan hasil geocoding presisi. Cukup akurat untuk
 * estimasi jarak garis lurus, tapi cek ulang / geocode ulang kalau nanti
 * fitur ini dihubungkan ke API rute sungguhan (Google Directions, OSRM, dll).
 */
class PlaceGeoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'monumen-nasional' => ['lat' => -6.1754, 'lng' => 106.8272, 'visit_duration_min' => 45, 'visit_duration_max' => 60, 'activity_tag' => 'Eksplorasi & Foto-foto'],
            'hutan-kota-gbk' => ['lat' => -6.2246, 'lng' => 106.8006, 'visit_duration_min' => 20, 'visit_duration_max' => 30, 'activity_tag' => 'Piknik Siang & Santai'],
            'pos-bloc-jakarta' => ['lat' => -6.1652, 'lng' => 106.8306, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Kuliner & Nongkrong'],
            'sarinah-thamrin' => ['lat' => -6.1868, 'lng' => 106.8230, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Belanja & Nongkrong'],
            'museum-nasional' => ['lat' => -6.1764, 'lng' => 106.8221, 'visit_duration_min' => 40, 'visit_duration_max' => 60, 'activity_tag' => 'Wisata Edukasi & Sejarah'],
            'kuliner-blok-m' => ['lat' => -6.2440, 'lng' => 106.7986, 'visit_duration_min' => 45, 'visit_duration_max' => 60, 'activity_tag' => 'Kuliner & Nongkrong'],
            'tebet-eco-park' => ['lat' => -6.2258, 'lng' => 106.8508, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Piknik & Olahraga Santai'],
            'taman-literasi-blok-m' => ['lat' => -6.2440, 'lng' => 106.7986, 'visit_duration_min' => 30, 'visit_duration_max' => 40, 'activity_tag' => 'Baca Buku & Santai'],
            'old-shanghai-sedayu-city' => ['lat' => -6.1656, 'lng' => 106.9420, 'visit_duration_min' => 40, 'visit_duration_max' => 60, 'activity_tag' => 'Wisata Kuliner & Foto-foto'],
            'taman-kota-waduk-ria-rio' => ['lat' => -6.1789, 'lng' => 106.8877, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Foto-foto & Santai Sore'],
            'tmii' => ['lat' => -6.3024, 'lng' => 106.8951, 'visit_duration_min' => 60, 'visit_duration_max' => 90, 'activity_tag' => 'Wisata Edukasi & Budaya'],
            'central-park-jakbar' => ['lat' => -6.1764, 'lng' => 106.7909, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Piknik & Santai Sore'],
            'museum-macan' => ['lat' => -6.1710, 'lng' => 106.7735, 'visit_duration_min' => 45, 'visit_duration_max' => 60, 'activity_tag' => 'Wisata Seni & Foto-foto'],
            'kuliner-green-ville' => ['lat' => -6.1567, 'lng' => 106.7815, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Wisata Kuliner'],
            'pantjoran-pik' => ['lat' => -6.1091, 'lng' => 106.7405, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Wisata Kuliner & Foto-foto'],
            'aloha-pik-2' => ['lat' => -6.0575, 'lng' => 106.6935, 'visit_duration_min' => 45, 'visit_duration_max' => 60, 'activity_tag' => 'Santai & Healing Sore'],
            'san-antonio-promenade' => ['lat' => -6.0580, 'lng' => 106.6900, 'visit_duration_min' => 30, 'visit_duration_max' => 45, 'activity_tag' => 'Jalan Santai & Bersepeda'],
        ];

        foreach ($data as $slug => $fields) {
            Place::where('slug', $slug)->update($fields);
        }
    }
}
