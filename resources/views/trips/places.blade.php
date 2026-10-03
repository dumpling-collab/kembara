<x-layouts.app title="Pilih Tempat & Destinasi" :bare="true">
    <div class="mx-auto max-w-327.5 px-6 py-10">
        <div class="flex items-center gap-3">
            <a href="{{ route('trips.create') }}" aria-label="Kembali" class="text-navy">←</a>
            <h1 class="text-3xl font-bold">Pilih Tempat &amp; Destinasi</h1>
        </div>

        <form method="GET" class="mt-6 max-w-3xl">
            <input type="search" name="q" value="{{ request('q') }}" class="field rounded-full"
                   placeholder="Cari nama tempat, cafe, atau landmark di Jakarta...">
            @if ($active) <input type="hidden" name="kategori" value="{{ $active }}"> @endif
        </form>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('trips.places', $trip) }}" class="chip {{ $active ? '' : 'chip-active' }}">Semua Tempat</a>
            @foreach ($categories as $c)
                <a href="{{ route('trips.places', [$trip, 'kategori' => $c->value]) }}"
                   class="chip {{ $active === $c->value ? 'chip-active' : '' }}">{{ $c->label() }}</a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_320px]">
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($places as $place)
                    <x-place-card :place="$place" :trip="$trip" />
                @empty
                    <p class="col-span-full text-ink-muted">Tidak ada tempat yang cocok dengan pencarianmu.</p>
                @endforelse
            </div>

            <x-trip-sidebar :trip="$trip" />
        </div>
    </div>
</x-layouts.app>
