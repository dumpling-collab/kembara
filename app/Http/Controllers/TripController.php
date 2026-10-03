<?php

namespace App\Http\Controllers;

use App\Enums\PlaceCategory;
use App\Models\Place;
use App\Models\Trip;
use App\Services\RouteEstimator;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /** Titik keberangkatan cepat yang bisa dipilih tanpa mengetik (koordinat perkiraan) */
    public const QUICK_STARTING_POINTS = [
        'Stasiun MRT Fatmawati' => ['lat' => -6.2911, 'lng' => 106.7987],
        'Stasiun Gambir' => ['lat' => -6.1767, 'lng' => 106.8306],
        'SCBD' => ['lat' => -6.2251, 'lng' => 106.8090],
    ];

    /** Layar "Rencanakan Perjalanan" */
    public function create()
    {
        return view('trips.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'budget' => ['required', 'integer', 'min:0'],
        ]);

        $trip = $request->user()->trips()->create($data);

        return redirect()->route('trips.places', $trip);
    }

    /** Layar "Pilih Tempat & Destinasi" */
    public function places(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $places = Place::query()
            ->search($request->string('q')->toString())
            ->category($request->string('kategori')->toString())
            ->orderByDesc('rating')->get();

        return view('trips.places', [
            'trip' => $trip->load('places'),
            'places' => $places,
            'categories' => PlaceCategory::cases(),
            'active' => $request->string('kategori')->toString(),
        ]);
    }

    public function togglePlace(Request $request, Trip $trip, Place $place)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $trip->places()->toggle([$place->id => ['position' => $trip->places()->count()]]);

        return back();
    }

    /** Layar "Dari Mana Kamu Akan Berangkat?" */
    public function startingPoint(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        $trip->load('places');
        abort_if($trip->places->isEmpty(), 400, 'Pilih minimal satu destinasi dulu.');

        $origin = $this->resolveOrigin($trip);
        $roughDuration = $origin
            ? app(RouteEstimator::class)->roughDurationRange($origin, $trip->places)
            : null;

        return view('trips.starting-point', [
            'trip' => $trip,
            'quickPoints' => array_keys(self::QUICK_STARTING_POINTS),
            'roughDuration' => $roughDuration,
        ]);
    }

    /** Simpan titik keberangkatan + urutan destinasi baru, lalu lanjut ke pilihan transportasi */
    public function saveStartingPoint(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'starting_point_name' => ['required', 'string', 'max:150'],
            'starting_point_lat' => ['nullable', 'numeric'],
            'starting_point_lng' => ['nullable', 'numeric'],
            'order' => ['nullable', 'string'], // daftar id tempat dipisah koma, hasil drag-and-drop
        ]);

        // Kalau titik awal cocok dengan salah satu quick point, pakai koordinatnya
        if (empty($data['starting_point_lat']) && isset(self::QUICK_STARTING_POINTS[$data['starting_point_name']])) {
            $data['starting_point_lat'] = self::QUICK_STARTING_POINTS[$data['starting_point_name']]['lat'];
            $data['starting_point_lng'] = self::QUICK_STARTING_POINTS[$data['starting_point_name']]['lng'];
        }

        $order = $data['order'] ?? null;
        unset($data['order']);

        $trip->update($data);

        if (! empty($order)) {
            foreach (explode(',', $order) as $position => $placeId) {
                $trip->places()->updateExistingPivot((int) $placeId, ['position' => $position]);
            }
        }

        return redirect()->route('trips.transport', $trip);
    }

    /** Layar "Estimasi Perjalanan & Pilihan Transportasi" */
    public function transport(Request $request, Trip $trip, RouteEstimator $estimator)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        $trip->load(['places' => fn ($q) => $q->orderByPivot('position')]);

        $origin = $this->resolveOrigin($trip);
        abort_if(! $origin, 400, 'Tentukan titik keberangkatan dulu.');

        $mode = $request->string('mode')->toString();
        $mode = in_array($mode, RouteEstimator::MODES, true) ? $mode : 'mobil';

        $result = $estimator->estimate($origin, $trip->places, $mode);

        return view('trips.transport', [
            'trip' => $trip,
            'mode' => $mode,
            'result' => $result,
        ]);
    }

    protected function resolveOrigin(Trip $trip): ?array
    {
        if (! $trip->starting_point_name) {
            return null;
        }

        return [
            'name' => $trip->starting_point_name,
            'lat' => (float) ($trip->starting_point_lat ?? -6.2000),
            'lng' => (float) ($trip->starting_point_lng ?? 106.8166),
        ];
    }
}
