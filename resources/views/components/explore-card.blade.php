@props(['place'])

@php
    $detailUrl = route('places.show', ['place' => $place, 'back' => urlencode(url()->full())]);
    $isFavorited = auth()->check() && auth()->user()->favoritePlaces->contains($place->id);
@endphp

<article class="overflow-hidden rounded-2xl bg-white shadow-soft">
    <div class="relative h-40">
        @if ($place->image)
            <img src="{{ asset($place->image) }}" alt="{{ $place->name }}" class="h-full w-full object-cover">
        @endif

        @if ($place->badge)
            <span class="absolute left-2.5 top-2.5 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold text-navy shadow-soft">
                {{ $place->badge }}
            </span>
        @endif

        <span class="absolute right-2.5 top-2.5 rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold shadow-soft">
            ★ {{ $place->rating }}
        </span>

        @auth
            <form method="POST" action="{{ route('places.favorite', $place) }}" class="absolute bottom-2.5 right-2.5">
                @csrf
                <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-full shadow-soft
                    {{ $isFavorited ? 'bg-red-500 text-white' : 'bg-white/90 text-slate-400' }}">
                    ❤
                </button>
            </form>
        @endauth
    </div>

    <div class="space-y-2 p-4">
        <h3 class="font-bold text-navy">{{ $place->name }}</h3>

        @if ($place->highlight_quote)
            <p class="flex items-start gap-1.5 rounded-lg bg-sky-soft px-2.5 py-2 text-xs italic leading-snug text-ink-muted">
                <span>💬</span> "{{ $place->highlight_quote }}"
            </p>
        @else
            <p class="text-xs leading-snug text-ink-muted">{{ $place->explore_summary ?? $place->description }}</p>
        @endif

        <a href="{{ $detailUrl }}"
           class="mt-3 block rounded-full border border-brand py-2 text-center text-sm font-bold text-brand transition hover:bg-brand hover:text-white">
            Lihat Detail →
        </a>
    </div>
</article>
