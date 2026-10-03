@props(['place', 'trip' => null])

@php
    $added = $trip?->places->contains($place->id);
    // Kirim URL halaman ini supaya tombol "Kembali" di detail tahu harus balik ke mana
    $detailUrl = route('places.show', ['place' => $place, 'back' => urlencode(url()->full())]);
@endphp

<article class="overflow-hidden rounded-3xl bg-surface shadow-soft transition {{ $added ? 'ring-2 ring-emerald-400' : '' }}">
    <a href="{{ $detailUrl }}" class="block">
        <div class="relative h-40 bg-slate-200">
            @if ($place->image)
                <img src="{{ asset($place->image) }}" alt="{{ $place->name }}" class="h-full w-full object-cover">
            @endif
            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-bold">★ {{ $place->rating }}</span>
        </div>
        <div class="space-y-2 p-4 pb-2">
            <span class="inline-block rounded-full bg-slate-200/70 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-ink-muted">
                {{ $place->category->label() }}
            </span>
            <h3 class="font-bold">{{ $place->name }}</h3>
            <p class="text-xs text-ink-muted">📍 {{ $place->address ?? $place->district }}</p>
        </div>
    </a>

    @if ($trip)
        <form method="POST" action="{{ route('trips.places.toggle', [$trip, $place]) }}" class="p-4 pt-2">
            @csrf
            <button class="w-full !py-2 text-sm font-bold rounded-full transition
                {{ $added ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'btn-brand' }}">
                {{ $added ? '✓ Ditambahkan' : '+ Tambah ke Trip' }}
            </button>
        </form>
    @endif
</article>
