<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengeCheckpoint;
use Illuminate\Database\Seeder;

/**
 * Sub-spot (checkpoint) tiap challenge, dibaca dari layar detail Figma
 * "Tantangan: Kuliner Legend Blok M" — satu-satunya yang sudah ada
 * screenshot detailnya.
 *
 * Reward Blok M diupdate dari 50 jadi 160 credits, mengikuti angka di
 * layar detail ("Hadiah: ... 160 Credits"), menggantikan angka lama
 * dari layar list yang menyebut "+50 PTS".
 *
 * 3 challenge lain (Kota Tua, PIK, Monas) BELUM ada screenshot detailnya,
 * jadi checkpoint-nya masih placeholder 1 spot generik supaya alurnya
 * tetap bisa dicoba. Kirim screenshot detail masing-masing kalau mau
 * datanya dilengkapi sesuai desain asli.
 */
class ChallengeCheckpointSeeder extends Seeder
{
    public function run(): void
    {
        $blokM = Challenge::where('slug', 'kuliner-legend-blok-m')->first();

        if ($blokM) {
            $blokM->update(['point_reward' => 160]);
            $blokM->checkpoints()->delete();

            $checkpoints = [
                ['name' => 'Gultik Blok M Plaza', 'description' => 'Nikmati seporsi gulai tikungan legendaris yang selalu ramai pengunjung.', 'tags' => ['Kuliner Malam', 'Legendaris']],
                ['name' => 'Filosofi Kopi Melawai', 'description' => 'Santai sejenak dengan secangkir kopi Tiwus di kedai ikonik ini.', 'tags' => ['Kafe', 'Hits']],
                ['name' => 'M Bloc Space', 'description' => 'Kunjungi creative hub terpopuler di Selatan Jakarta dan temukan spot foto terbaikmu.', 'tags' => ['Outdoor']],
            ];

            foreach ($checkpoints as $i => $cp) {
                ChallengeCheckpoint::create([
                    'challenge_id' => $blokM->id,
                    'name' => $cp['name'],
                    'description' => $cp['description'],
                    'tags' => $cp['tags'],
                    'image' => $blokM->image, // placeholder, belum ada foto per-spot
                    'position' => $i,
                ]);
            }
        }

        // Placeholder: 1 checkpoint generik untuk 3 challenge lain, supaya
        // alur "verifikasi lalu klaim" tetap bisa dicoba sebelum data aslinya ada.
        foreach (['jejak-kolonial-kota-tua', 'sunset-breeze-pik', 'wisata-sejarah-monas'] as $slug) {
            $challenge = Challenge::where('slug', $slug)->first();
            if (! $challenge || $challenge->checkpoints()->exists()) {
                continue;
            }

            ChallengeCheckpoint::create([
                'challenge_id' => $challenge->id,
                'name' => $challenge->title,
                'description' => 'Kunjungi dan tandai lokasi ini untuk menyelesaikan tantangan. (Data sub-spot lengkap menyusul)',
                'tags' => [$challenge->district],
                'image' => $challenge->image,
                'position' => 0,
            ]);
        }
    }
}
