<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            ['slug' => 'monumen-nasional', 'name' => 'Monumen Nasional', 'category' => 'sejarah', 'tagline' => 'Sejarah & Budaya', 'district' => 'Jakarta Pusat', 'address' => 'Gambir, Jakarta Pusat', 'rating' => 4.9, 'image' => 'images/places/monas.jpg', 'is_featured' => true, 'is_top_pick' => true],
            ['slug' => 'pos-bloc-jakarta', 'name' => 'Pos Bloc Jakarta', 'category' => 'kuliner', 'tagline' => 'Kreatif & Kuliner', 'district' => 'Jakarta Pusat', 'address' => 'Sawah Besar, Jakarta Pusat', 'rating' => 4.7, 'image' => 'images/places/pos-bloc.jpg', 'is_featured' => true],
            ['slug' => 'hutan-kota-gbk', 'name' => 'Hutan Kota GBK', 'category' => 'outdoor', 'tagline' => 'Alam & Rekreasi', 'district' => 'Jakarta Pusat', 'address' => 'Senayan, Jakarta Pusat', 'rating' => 4.8, 'image' => 'images/places/hutan-kota-gbk.jpg', 'is_featured' => true],
            ['slug' => 'sarinah-thamrin', 'name' => 'Sarinah Thamrin', 'category' => 'belanja', 'tagline' => 'Belanja & Gaya Hidup', 'district' => 'Jakarta Pusat', 'address' => 'Thamrin, Jakarta Pusat', 'rating' => 4.8, 'image' => 'images/places/sarinah.jpg'],
        ];
        foreach ($places as $p) {
            Place::updateOrCreate(['slug' => $p['slug']], $p);
        }

        $challenges = [
            ['slug' => 'kuliner-legend-blok-m', 'title' => 'Kuliner Legend Blok M', 'district' => 'Jakarta Selatan', 'point_reward' => 50, 'image' => 'images/places/blok-m.jpg'],
            ['slug' => 'jejak-kolonial-kota-tua', 'title' => 'Jejak Kolonial Kota Tua', 'district' => 'Jakarta Barat', 'point_reward' => 60, 'image' => 'images/places/kota-tua.jpg'],
            ['slug' => 'sunset-breeze-pik', 'title' => 'Sunset & Breeze PIK', 'district' => 'Jakarta Utara', 'point_reward' => 50, 'image' => 'images/places/pik.jpg'],
            ['slug' => 'wisata-sejarah-monas', 'title' => 'Wisata Sejarah Monas', 'district' => 'Jakarta Pusat', 'point_reward' => 75, 'image' => 'images/places/monas.jpg'],
        ];
        foreach ($challenges as $c) {
            Challenge::updateOrCreate(['slug' => $c['slug']], $c);
        }
    }
}
