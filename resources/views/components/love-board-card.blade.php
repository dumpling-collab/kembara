@props(['trip'])

@php
    $icons = [
        'sejarah' => '🏛️', 'outdoor' => '🌳', 'kuliner' => '🍜',
        'belanja' => '🛍️', 'instagramable' => '📸',
    ];
    $shortName = fn ($name) => trim(explode('(', $name)[0]);
    $title = 'Jelajah ' . $trip->starting_point_name . ' - ' . $trip->places->map(fn ($p) => $shortName($p->name))->join(' - ');
@endphp

<article class="overflow-hidden rounded-3xl bg-surface shadow-soft transition {{ $trip->is_favorite_route ? 'ring-2 ring-emerald-400' : '' }}">
    @if ($trip->places->first()?->image)
        <img src="{{ asset($trip->places->first()->image) }}" alt="{{ $title }}" class="h-40 w-full object-cover">
    @endif

    <div class="space-y-3 p-5">
        <h3 class="font-bold text-navy">{{ $title }}</h3>

        <div class="space-y-1 rounded-xl bg-white p-3 text-sm shadow-soft">
            <p>📍 {{ $trip->starting_point_name }}</p>
            @foreach ($trip->places as $place)
                <p class="pl-4 text-ink-muted">↓</p>
                <p>{{ $icons[$place->category->value] ?? '📍' }} {{ $shortName($place->name) }}</p>
            @endforeach
        </div>

        @if (! is_null($trip->computed_total))
            <p class="text-xs text-ink-muted">
                Estimasi Biaya: Rp{{ number_format($trip->computed_total, 0, ',', '.') }} • {{ $trip->mode_label }}
            </p>
        @endif

        <div class="flex items-center gap-2 pt-1">
            <a href="{{ route('trips.transport', [$trip, 'mode' => $trip->transport_mode ?? 'mobil']) }}"
               class="btn-navy flex-1 justify-center !py-2 text-sm">Buka Detail Rute</a>

            @php $shareUrl = route('trips.transport', [$trip, 'mode' => $trip->transport_mode ?? 'mobil']); @endphp
            <button type="button"
                    onclick="navigator.share ? navigator.share({title: @js($title), url: '{{ $shareUrl }}'}) : (navigator.clipboard.writeText('{{ $shareUrl }}'), alert('Link disalin!'))"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-white text-navy shadow-soft">
                ⤴
            </button>

            <form method="POST" action="{{ route('love-board.favorite', $trip) }}">
                @csrf
                <button type="submit"
                        class="flex h-9 w-9 items-center justify-center rounded-full shadow-soft
                        {{ $trip->is_favorite_route ? 'bg-red-100 text-red-500' : 'bg-white text-slate-300' }}">
                    ❤
                </button>
            </form>
        </div>
    </div>
</article>
