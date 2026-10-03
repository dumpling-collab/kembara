@php
    $tabs = [
        'semua' => 'Semua Rencana',
        'aktif' => 'Rencana Aktif',
        'favorit' => 'Rute Favorit',
        'inspirasi' => 'Inspirasi Spot',
    ];
@endphp

<x-layouts.app title="Love Board">
    <div class="mx-auto max-w-[1310px] px-6 py-10">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-white shadow-soft">←</a>
            <h1 class="text-3xl font-extrabold text-navy">Love Board ❤️</h1>
        </div>
        <p class="mt-2 text-sm text-ink-muted">Kumpulan rute favorit, rencana perjalanan tersimpan, dan inspirasi petualanganmu di Jakarta.</p>

        @if (session('status'))
            <p class="mt-4 rounded-xl bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">{{ session('status') }}</p>
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            @foreach ($tabs as $key => $label)
                <a href="{{ route('love-board.index', ['tab' => $key]) }}"
                   class="chip {{ $tab === $key ? 'chip-active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @if ($tab === 'inspirasi')
                @forelse ($favoritePlaces as $place)
                    <article class="overflow-hidden rounded-3xl bg-surface shadow-soft">
                        @if ($place->image)
                            <img src="{{ asset($place->image) }}" alt="{{ $place->name }}" class="h-40 w-full object-cover">
                        @endif
                        <div class="space-y-2 p-4">
                            <h3 class="font-bold">{{ $place->name }}</h3>
                            <p class="text-xs text-ink-muted">{{ $place->district }}</p>
                            <div class="flex gap-2 pt-1">
                                <a href="{{ route('places.show', $place) }}" class="btn-navy flex-1 justify-center !py-2 text-sm">Lihat Detail</a>
                                <form method="POST" action="{{ route('places.favorite', $place) }}">
                                    @csrf
                                    <button class="flex h-9 w-9 items-center justify-center rounded-full bg-red-100 text-red-500 shadow-soft">❤</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full text-ink-muted">
                        Belum ada tempat yang kamu suka. Klik ikon ❤ di kartu Explore untuk menyimpannya di sini.
                    </p>
                @endforelse
            @else
                @forelse ($trips as $trip)
                    <x-love-board-card :trip="$trip" />
                @empty
                    <p class="text-ink-muted">Belum ada rencana tersimpan di tab ini.</p>
                @endforelse

                @if ($tab === 'semua')
                    <a href="{{ route('trips.create') }}"
                       class="flex min-h-[260px] flex-col items-center justify-center gap-2 rounded-3xl border-2 border-dashed border-slate-300 text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-2xl text-navy">+</span>
                        <span class="font-bold text-navy">Buat Board / Rencana Baru</span>
                        <span class="text-sm text-ink-muted">Mulai petualangan baru</span>
                    </a>
                @endif
            @endif
        </div>
    </div>
</x-layouts.app>
