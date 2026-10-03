<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Trip;
use App\Services\RouteEstimator;
use Illuminate\Http\Request;

class LoveBoardController extends Controller
{
    public const MODE_LABELS = [
        'umum' => 'Transportasi Umum',
        'motor' => 'Motor',
        'mobil' => 'Mobil',
    ];

    public function index(Request $request, RouteEstimator $estimator)
    {
        $tab = $request->string('tab')->toString() ?: 'semua';

        $trips = $request->user()->trips()
            ->whereNotNull('saved_to_love_board_at')
            ->with('places')
            ->orderByDesc('saved_to_love_board_at')
            ->get();

        if ($tab === 'aktif') {
            $trips = $trips->filter(fn ($t) => $t->end_date->isFuture() || $t->end_date->isToday());
        } elseif ($tab === 'favorit') {
            $trips = $trips->where('is_favorite_route', true);
        }

        // Hitung ulang estimasi biaya tiap trip (data selalu segar, tidak disimpan statis)
        $trips = $trips->map(function (Trip $trip) use ($estimator) {
            $origin = $trip->starting_point_name ? [
                'name' => $trip->starting_point_name,
                'lat' => (float) ($trip->starting_point_lat ?? -6.2000),
                'lng' => (float) ($trip->starting_point_lng ?? 106.8166),
            ] : null;

            $trip->computed_total = $origin
                ? $estimator->estimate($origin, $trip->places, $trip->transport_mode ?? 'mobil')['total']
                : null;
            $trip->mode_label = self::MODE_LABELS[$trip->transport_mode ?? 'mobil'];

            return $trip;
        });

        $favoritePlaces = $tab === 'inspirasi'
            ? $request->user()->favoritePlaces()->get()
            : collect();

        return view('love-board.index', [
            'tab' => $tab,
            'trips' => $trips,
            'favoritePlaces' => $favoritePlaces,
        ]);
    }

    /** Dipanggil dari tombol "Simpan ke Love Board" di halaman Estimasi & Transportasi */
    public function save(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $mode = $request->string('mode')->toString();
        $mode = array_key_exists($mode, self::MODE_LABELS) ? $mode : 'mobil';

        $trip->update([
            'saved_to_love_board_at' => now(),
            'transport_mode' => $mode,
        ]);

        return redirect()->route('love-board.index')->with('status', 'Trip disimpan ke Love Board!');
    }

    public function toggleFavoriteRoute(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $trip->update(['is_favorite_route' => ! $trip->is_favorite_route]);

        return back();
    }

    public function togglePlaceFavorite(Request $request, Place $place)
    {
        $request->user()->favoritePlaces()->toggle($place->id);

        return back();
    }
}
