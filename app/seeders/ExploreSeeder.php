<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

/**
 * Data untuk halaman Explore (tab "Tempat Hits" + 5 wilayah).
 * Semua foto sekarang memakai file asli (bukan placeholder pinjaman lagi).
 */
class ExploreSeeder extends Seeder
{
    public function run(): void
    {
        Place::whereIn('slug', ['kemang', 'jakarta-timur-heritage', 'glodok', 'ancol'])->delete();

        $places = [
            // ===== Jakarta Pusat =====
            [
                'slug' => 'monumen-nasional', 'name' => 'Monas (National Monument)',
                'category' => 'sejarah', 'district' => 'Jakarta Pusat', 'address' => 'Gambir, Jakarta Pusat',
                'rating' => 4.8, 'image' => 'images/places/monas.jpg', 'is_featured' => true, 'is_top_pick' => true,
                'badge' => 'Sejarah & Ikon Jakarta',
                'explore_summary' => 'Landmark paling ikonik di Jakarta yang pas buat piknik pagi, olahraga, dan foto-foto.',
            ],
            [
                'slug' => 'museum-nasional', 'name' => 'Museum Nasional',
                'category' => 'sejarah', 'district' => 'Jakarta Pusat', 'address' => 'Gambir, Jakarta Pusat',
                'rating' => 4.7, 'image' => 'images/places/museum-nasional.jpeg',
                'badge' => 'Sejarah & Budaya',
                'highlight_quote' => 'Jangan lewatkan sayap kanan yang sangat ikonik',
            ],
            [
                'slug' => 'sarinah-thamrin', 'name' => 'Sarinah',
                'category' => 'belanja', 'district' => 'Jakarta Pusat', 'address' => 'Thamrin, Jakarta Pusat',
                'rating' => 4.7, 'image' => 'images/places/sarinah.jpg',
                'badge' => 'Belanja & Gaya Hidup',
                'explore_summary' => 'Spot belanja produk lokal, tempat pameran seni, dan area nongkrong outdoor dekat Monas.',
            ],

            // ===== Jakarta Selatan =====
            [
                'slug' => 'kuliner-blok-m', 'name' => 'Blok M',
                'category' => 'kuliner', 'district' => 'Jakarta Selatan', 'address' => 'Blok M, Jakarta Selatan',
                'rating' => 4.6, 'image' => 'images/places/blok-m.jpg',
                'badge' => 'Creative Hub & Kuliner',
                'explore_summary' => 'Creative space hits dengan vibe vintage, wisata kuliner, dan spot nongkrong.',
            ],
            [
                'slug' => 'tebet-eco-park', 'name' => 'Tebet Eco Park',
                'category' => 'outdoor', 'district' => 'Jakarta Selatan', 'address' => 'Tebet, Jakarta Selatan',
                'rating' => 4.8, 'image' => 'images/places/tebet-eco-park.jpeg',
                'badge' => 'Outdoor',
                'highlight_quote' => 'Tempat foto ikonik dengan konsep hijau, ada jembatan gantung dan spot foto tengah taman.',
            ],
            [
                'slug' => 'taman-literasi-blok-m', 'name' => 'Taman Literasi Blok M',
                'category' => 'outdoor', 'district' => 'Jakarta Selatan', 'address' => 'Blok M, Jakarta Selatan',
                'rating' => 4.7, 'image' => 'images/places/taman-literasi-blok-m.jpeg',
                'badge' => 'Taman & Edukasi',
                'explore_summary' => 'Taman kota modern buat baca buku, kerja santai, dan nikmati sore.',
            ],

            // ===== Jakarta Timur =====
            [
                'slug' => 'old-shanghai-sedayu-city', 'name' => 'Old Shanghai Sedayu City',
                'category' => 'kuliner', 'district' => 'Jakarta Timur', 'address' => 'Sedayu City, Jakarta Timur',
                'rating' => 4.8, 'image' => 'images/places/old-shanghai-sedayu-city.jpeg',
                'badge' => 'Kuliner & Wisata',
                'explore_summary' => 'Destinasi kuliner tematik bergaya oriental yang estetik dan cocok buat foto-foto.',
            ],
            [
                'slug' => 'taman-kota-waduk-ria-rio', 'name' => 'Taman Kota Waduk Ria Rio',
                'category' => 'outdoor', 'district' => 'Jakarta Timur', 'address' => 'Pulomas, Jakarta Timur',
                'rating' => 4.7, 'image' => 'images/places/taman-kota-waduk-ria-rio.jpeg',
                'badge' => 'Outdoor & Nature',
                'highlight_quote' => 'Taman kota dengan danau yang instagramable, sering ada spot foto sunset di sini.',
            ],
            [
                'slug' => 'tmii', 'name' => 'Taman Mini Indonesia Indah (TMII)',
                'category' => 'outdoor', 'district' => 'Jakarta Timur', 'address' => 'TMII, Jakarta Timur',
                'rating' => 4.9, 'image' => 'images/places/tmii.jpeg',
                'badge' => 'Edukasi & Wisata',
                'explore_summary' => 'Wajah baru TMII yang ramah pejalan kaki dengan keindahan miniatur budaya nusantara.',
            ],

            // ===== Jakarta Barat =====
            [
                'slug' => 'central-park-jakbar', 'name' => 'Central Park',
                'category' => 'outdoor', 'district' => 'Jakarta Barat', 'address' => 'Podomoro City, Jakarta Barat',
                'rating' => 4.6, 'image' => 'images/places/central-park.jpeg',
                'badge' => 'Outdoor & Chill',
                'explore_summary' => 'Taman terbuka hijau di dalam mall yang luas, ramah hewan peliharaan, dan pas buat santai sore.',
            ],
            [
                'slug' => 'museum-macan', 'name' => 'Museum MACAN',
                'category' => 'instagramable', 'district' => 'Jakarta Barat', 'address' => 'Kebon Jeruk, Jakarta Barat',
                'rating' => 4.8, 'image' => 'images/places/museum-macan.jpeg',
                'badge' => 'Seni & Foto',
                'explore_summary' => 'Galeri seni kontemporer internasional dengan spot foto estetik dan pameran instagramable.',
            ],
            [
                'slug' => 'kuliner-green-ville', 'name' => 'Kuliner Green Ville',
                'category' => 'kuliner', 'district' => 'Jakarta Barat', 'address' => 'Green Ville, Jakarta Barat',
                'rating' => 4.7, 'image' => 'images/places/green-ville.jpeg',
                'badge' => 'Kuliner & Resto',
                'explore_summary' => 'Surga kuliner legendaris Jakbar yang menyajikan ragam makanan lokal dan kekinian.',
            ],

            // ===== Jakarta Utara =====
            [
                'slug' => 'pantjoran-pik', 'name' => 'Pantjoran PIK',
                'category' => 'kuliner', 'district' => 'Jakarta Utara', 'address' => 'PIK, Jakarta Utara',
                'rating' => 4.8, 'image' => 'images/places/pantjoran-pik.jpeg',
                'badge' => 'Kuliner & Heritage',
                'explore_summary' => 'Pusat kuliner tematik bergaya pecinan modern dengan gapura megah dan pagoda ikonik.',
            ],
            [
                'slug' => 'aloha-pik-2', 'name' => 'Aloha PIK 2',
                'category' => 'outdoor', 'district' => 'Jakarta Utara', 'address' => 'PIK 2, Jakarta Utara',
                'rating' => 4.8, 'image' => 'images/places/aloha-pik-2.jpeg',
                'badge' => 'Outdoor & Beach',
                'highlight_quote' => 'Cocok buat healing santai sore dengan suasana pantai yang instagramable.',
            ],
            [
                'slug' => 'san-antonio-promenade', 'name' => 'San Antonio Promenade',
                'category' => 'outdoor', 'district' => 'Jakarta Utara', 'address' => 'PIK 2, Jakarta Utara',
                'rating' => 4.7, 'image' => 'images/places/san-antonio.jpg',
                'badge' => 'Outdoor & Chill',
                'explore_summary' => 'Area pejalan kaki di tepi laut yang pas buat naik sepeda, jalan santai, dan nikmati sore.',
            ],
        ];

        foreach ($places as $p) {
            Place::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
