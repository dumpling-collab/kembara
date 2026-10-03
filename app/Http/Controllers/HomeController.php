<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke(GeminiService $gemini)
    {
        // Kandidat yang boleh direkomendasikan: tempat dengan rating cukup baik
        $candidates = Place::where('rating', '>=', 4.5)->orderByDesc('rating')->take(12)->get();

        $picks = Cache::remember(
            'home:ai-recommendations:' . now()->toDateString(),
            now()->endOfDay(),
            fn () => $gemini->recommend($candidates, 3)
        );

        if ($picks) {
            // Urutan & alasan dari AI, tapi datanya tetap dari Place yang sudah ada
            $places = collect($picks)
                ->map(fn ($pick) => [
                    'place' => $candidates->firstWhere('id', $pick['id']),
                    'reason' => $pick['reason'],
                ])
                ->filter(fn ($p) => $p['place'] !== null)
                ->values();

            $topPick = $places->first()['place'] ?? null;
            $topPickReason = $places->first()['reason'] ?? null;
            $others = $places->slice(1)->pluck('place');
            $othersReasons = $places->slice(1)->pluck('reason', 'place.id');
            $usedAi = true;
        } else {
            // Fallback: logika lama (is_top_pick lalu urut rating), tanpa AI
            $topPick = Place::where('is_top_pick', true)->first() ?? $candidates->first();
            $others = Place::where('is_featured', true)
                ->when($topPick, fn ($q) => $q->whereKeyNot($topPick->id))
                ->orderByDesc('rating')->take(2)->get();
            $topPickReason = null;
            $othersReasons = collect();
            $usedAi = false;
        }

        return view('home', compact('topPick', 'others', 'topPickReason', 'othersReasons', 'usedAi'));
    }
}
