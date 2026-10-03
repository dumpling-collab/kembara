<?php

namespace App\Http\Controllers;

use App\Enums\PlaceCategory;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /** 5 wilayah Jakarta untuk tab Explore, plus tab default "Tempat Hits" */
    public const DISTRICTS = [
        'jakarta-pusat' => 'Jakarta Pusat',
        'jakarta-selatan' => 'Jakarta Selatan',
        'jakarta-timur' => 'Jakarta Timur',
        'jakarta-barat' => 'Jakarta Barat',
        'jakarta-utara' => 'Jakarta Utara',
    ];

    /**
     * Satu halaman Explore dengan beberapa tab: "hits" (default) dan tiap wilayah.
     * Route: /explore  →  tab "hits"
     *        /explore/jakarta-pusat, dst.
     */
    public function index(Request $request, string $tab = 'hits')
    {
        // Kalau user mengetik pencarian, tampilkan hasil datar lintas wilayah
        if ($request->filled('q') || $request->filled('kategori')) {
            $places = Place::query()
                ->search($request->string('q')->toString())
                ->category($request->string('kategori')->toString())
                ->orderByDesc('rating')
                ->get();

            return view('places.explore', [
                'searching' => true,
                'places' => $places,
                'categories' => PlaceCategory::cases(),
                'active' => $request->string('kategori')->toString(),
                'tab' => $tab,
                'districts' => self::DISTRICTS,
            ]);
        }

        if ($tab === 'hits') {
            $heading = 'Rekomendasi Tempat Hits!';
            $places = Place::orderByDesc('rating')->take(3)->get();
        } else {
            abort_unless(array_key_exists($tab, self::DISTRICTS), 404);
            $districtName = self::DISTRICTS[$tab];
            $heading = "Rekomendasi Tempat di {$districtName}!";
            $places = Place::where('district', $districtName)->orderByDesc('rating')->get();
        }

        return view('places.explore', [
            'searching' => false,
            'tab' => $tab,
            'heading' => $heading,
            'places' => $places,
            'districts' => self::DISTRICTS,
        ]);
    }

    /** Layar detail tempat */
    public function show(Request $request, Place $place)
    {
        $trip = $request->user()?->trips()->where('status', 'draft')->latest()->first();
        $inTrip = $trip ? $trip->places()->whereKey($place->id)->exists() : false;

        return view('places.show', compact('place', 'trip', 'inTrip'));
    }
}
