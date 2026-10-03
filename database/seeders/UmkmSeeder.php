<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\UmkmRecommendation;
use Illuminate\Database\Seeder;

/**
 * Rekomendasi UMKM per destinasi, dari dokumen "Data UMKM dan Jam Operasional
 * Destinasi Wisata Jakarta".
 *
 * CATATAN: "Blok M Square" di dokumen aslinya adalah destinasi tersendiri,
 * tapi belum ada sebagai Place terpisah di sistem kita — UMKM-nya digabung
 * ke destinasi "Blok M" (slug: kuliner-blok-m) yang sudah ada. Kalau Blok M
 * Square perlu jadi destinasi sendiri, buat Place baru dulu lalu pindahkan
 * data ini ke slug yang baru.
 */
class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'pos-bloc-jakarta' => [
                ['Sedjuk Bakmi & Kopi', 'Kuliner mi dan kopi lokal populer', '10.00–22.00'],
                ['Tauto KedungRasa', 'Kuliner otentik soto tauco khas Pekalongan', '10.00–22.00'],
                ['Filosofi Kopi', 'Kedai kopi lokal independen yang ikonik', '07.00–22.00'],
                ["Mael's Cafe", 'Kafe lokal penyedia menu nusantara seperti mi Aceh', '10.00–22.00'],
                ['Bakso Cendol Pakde Jenggot (Bandol)', 'Kuliner bakso dan es cendol legendaris', '10.00–22.00'],
                ['Pos Ribs', 'Kuliner iga bakar lokal', '10.00–22.00'],
            ],
            'sarinah-thamrin' => [
                ['Pasar Nusantara', 'Area khusus pujasera dan stan UMKM kuliner tradisional dari berbagai daerah', '10.00–22.00'],
                ['Galeri Kriya & Wastra UMKM', 'Berisi ratusan stan perajin lokal yang menjual produk batik, tenun, tas kulit lokal, aksesori, hingga dekorasi rumah buatan tangan', '10.00–22.00'],
            ],
            'pantjoran-pik' => [
                ['Kopi Es Tak Kie', 'Kedai kopi legendaris turun-temurun asal Glodok', '07.00–21.00'],
                ['Wong Fu Kie', 'Restoran masakan Tionghoa Hakka autentik legendaris', '10.00–21.00'],
                ['Kari Lam', 'Kuliner kari legendaris', '08.00–21.00'],
                ['Cendol Pandan / Ci Cong Fan Pluit Sakti', 'Deretan UMKM jajanan lokal khas peranakan', '07.00–21.00'],
                ['Hoy Tod & Master Squid', 'Gerai street food makanan laut', '10.00–22.00'],
            ],
            'old-shanghai-sedayu-city' => [
                ['K3Mart', 'Swalayan jajanan impor & lokal', '10.00–22.00'],
                ['Kwetiau Aboy & Choipan Mei Mei', 'UMKM kuliner khas lokal yang populer', '10.00–22.00'],
                ['Bakmi Kangkung Berkat', 'UMKM mi kangkung legendaris Nusantara', '10.00–22.00'],
            ],
            'hutan-kota-gbk' => [
                ['Mad Bagel', 'UMKM bakery spesialis roti bagel dengan berbagai varian rasa', '08.00–21.00'],
                ['RM Lokiin', 'UMKM kuliner spesialis hidangan Nusantara seperti Nasi Lidah bumbu hitam', '08.00–21.00'],
                ['Chuchat / Chutchat', 'UMKM minuman dan dessert kekinian', '08.00–21.00'],
                ['Fuku', 'Tenant kuliner jajanan siap saji', '08.00–21.00'],
                ['Eight Tarts', 'UMKM produk kue pai/tart', '08.00–21.00'],
            ],
            'tebet-eco-park' => [
                ['Kopi Nako Tebet', 'Kedai kopi lokal populer berkonsep semi-outdoor', '08.00–23.00'],
                ['Serabi Tebet', 'Warung tenda UMKM kuliner tradisional yang menjual serabi khas Bandung dengan beragam topping seperti oncom dan durian', '16.00–22.00'],
                ['Darling Habit Bake & Butter', 'UMKM bakery dan pastry lokal', '09.00–22.00'],
                ['Taqueria Sanrsise', 'UMKM street food makanan Meksiko autentik skala mikro', '10.00–22.00'],
                ['Lestari Coffee', 'Kedai kopi artisanal lokal', '09.00–22.00'],
            ],
            'taman-literasi-blok-m' => [
                ['Koleksi Titik Baca & Gerai Buku Lokal', 'Fasilitas literasi dan ruang bagi kreator buku independen', '07.00–21.00'],
                ['Tenant Kafe & Kedai Kopi Literasi', 'Berbagai gerai minuman dan kopi lokal yang dikurasi untuk pengunjung area taman membaca', '09.00–22.00'],
            ],
            // "Blok M Square" digabung ke destinasi "Blok M" yang sudah ada — lihat catatan di atas.
            'kuliner-blok-m' => [
                ['Pujasera Blok M Square (Basement/Lantai UG)', 'Warteg & Warung Nasi Campur Nusantara', '10.00–21.00'],
                ['Kedai Soto & Bakso Lokal', 'Berbagai gerai UMKM soto mie, bakso, dan mi ayam rumahan', '10.00–21.00'],
                ['Sentra Buku & Musik Bekas Basement Blok M Square', 'Kumpulan UMKM pedagang buku independen, kaset, piringan hitam, serta jasa servis/sablon lokal', '10.00–21.00'],
            ],
        ];

        foreach ($data as $slug => $items) {
            $place = Place::where('slug', $slug)->first();
            if (! $place) {
                continue;
            }

            $place->umkmRecommendations()->delete(); // supaya aman dijalankan ulang

            foreach ($items as $i => [$name, $description, $hours]) {
                UmkmRecommendation::create([
                    'place_id' => $place->id,
                    'name' => $name,
                    'description' => $description,
                    'opening_hours' => $hours,
                    'position' => $i,
                ]);
            }
        }
    }
}
