<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

/**
 * Mengisi data halaman detail. Hanya meng-update kolom detail,
 * jadi aman dijalankan berkali-kali dan tidak menimpa foto/rating.
 */
class PlaceDetailSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            // Sumber: layar Figma "Hutan Kota GBK"
            'hutan-kota-gbk' => [
                'badge' => 'Outdoor & Hutan Kota',
                'reviews_count' => 1200,
                'opening_hours' => '06.00 - 18.00',
                'ticket_price' => 'Gratis',
                'access_info' => '5 mnt dr MRT',
                'description' => 'Area seluas 4 hektar yang dulunya merupakan lapangan golf kini disulap menjadi paru-paru kota Jakarta. Tempat sempurna untuk piknik sore hari sambil menikmati kontrasnya hamparan rumput hijau berlatarkan gedung-gedung pencakar langit SCBD yang megah.',
                'bara_story' => 'Hutan kota ini adalah bukti nyata transformasi Jakarta! Dari area komersial eksklusif menjadi ruang terbuka hijau yang bisa dinikmati semua orang.',
                'bara_tip' => 'Datanglah sekitar jam 4 sore. Cahaya keemasannya sempurna untuk foto siluet dengan latar gedung SCBD!',
            ],

            // Sumber: layar Figma "Monas" — dicocokkan dari screenshot desain
            'monumen-nasional' => [
                'badge' => 'Sejarah & Ikon Jakarta',
                'reviews_count' => 15400,
                'opening_hours' => '06.00 - 22.00',
                'ticket_price' => 'Rp8.000 - Rp24.000',
                'access_info' => '2 mnt dr Halte Monas',
                'description' => 'Ikon kebangsaan Indonesia setinggi 132 meter yang digagas oleh Presiden Soekarno. Selain menyajikan panorama megah lanskap kota Jakarta dari Puncak Cawan, Monas menyimpan Museum Sejarah Nasional di bagian bawahnya yang menampilkan puluhan diorama perjuangan bangsa.',
                'bara_story' => 'Monas itu bukan cuma soal tugu emas di puncaknya, tapi simbol semangat Jakarta! Lorong museum di bawahnya selalu punya cara buat bikin kita terpukau sama sejarah bangsa.',
                'bara_tip' => 'Datanglah jam 8 pagi kalau mau naik ke Puncak Cawan tanpa antrean yang mengular, atau nikmati pertunjukan air mancur menari gratis di kawasan sekitar tiap akhir pekan jam 7 malam!',
            ],

            'pos-bloc-jakarta' => [
                'badge' => 'Kreatif & Kuliner',
                'description' => 'Bekas kantor pos bersejarah yang disulap menjadi ruang kreatif, kuliner, dan komunitas.',
            ],
            'sarinah-thamrin' => [
                'badge' => 'Belanja & Gaya Hidup',
                'description' => 'Pusat perbelanjaan tertua di Jakarta, kini hadir dengan wajah baru di kawasan Thamrin.',
            ],
        ];

        foreach ($details as $slug => $data) {
            Place::where('slug', $slug)->update($data);
        }
    }
}
