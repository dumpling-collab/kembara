@props(['trip'])

<aside class="h-fit rounded-3xl bg-surface p-6 shadow-soft lg:sticky lg:top-6">
    <div class="flex items-center justify-between">
        <h2 class="font-bold text-navy">Destinasi Terpilih</h2>
        <span class="rounded-full bg-navy px-3 py-1 text-xs font-bold text-white">
            {{ $trip->places->count() }} Tempat
        </span>
    </div>

    <ul class="mt-4 space-y-2">
        @forelse ($trip->places as $p)
            <li class="flex items-center gap-3 rounded-xl bg-white p-2 shadow-soft">
                <span class="cursor-grab text-slate-300" title="Urutkan (segera hadir)">⠿</span>

                <img src="{{ $p->image ? asset($p->image) : '' }}" alt="{{ $p->name }}"
                     class="h-10 w-10 rounded-lg bg-slate-200 object-cover">

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold leading-tight">{{ $p->name }}</p>
                    <p class="text-xs text-ink-muted">{{ $p->category->label() }}</p>
                </div>

                <form method="POST" action="{{ route('trips.places.toggle', [$trip, $p]) }}">
                    @csrf
                    <button class="text-slate-400 hover:text-red-500" title="Hapus dari trip">🗑</button>
                </form>
            </li>
        @empty
            <li class="rounded-xl bg-white p-4 text-center text-sm text-ink-muted shadow-soft">
                Belum ada destinasi dipilih.
            </li>
        @endforelse
    </ul>

    <a href="{{ $trip->places->isNotEmpty() ? route('trips.route', $trip) : '#' }}"
       @class([
           'btn-brand mt-6 block w-full text-center',
           'pointer-events-none opacity-50' => $trip->places->isEmpty(),
       ])>
        Lanjut ke Estimasi &amp; Rute →
    </a>
</aside>
