<x-layouts.app title="Explore">
    <div class="mx-auto max-w-327.5 px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" aria-label="Kembali" class="text-navy">←</a>
                <h1 class="text-2xl font-extrabold text-navy sm:text-3xl">Eksplor Jakarta Bareng Bara 🧭</h1>
            </div>

            <form method="GET" action="{{ route('places.index') }}" class="w-full sm:w-72">
                <input type="search" name="q" value="{{ request('q') }}" class="field rounded-full text-sm"
                       placeholder="Cari destinasi...">
            </form>
        </div>

        {{-- Tab: Tempat Hits + 5 wilayah --}}
        <div class="mt-6 flex flex-wrap gap-2">
            <a href="{{ route('places.index') }}"
               class="chip {{ $tab === 'hits' && !($searching ?? false) ? 'chip-active' : '' }}">Tempat Hits</a>
            @foreach ($districts as $slug => $name)
                <a href="{{ route('places.tab', $slug) }}"
                   class="chip {{ $tab === $slug && !($searching ?? false) ? 'chip-active' : '' }}">{{ $name }}</a>
            @endforeach
        </div>

        @if ($searching)
            {{-- Hasil pencarian datar lintas wilayah --}}
            <div class="mt-5 flex flex-wrap gap-3">
                @foreach ($categories as $c)
                    <a href="{{ route('places.index', ['kategori' => $c->value, 'q' => request('q')]) }}"
                       class="chip {{ $active === $c->value ? 'chip-active' : '' }}">{{ $c->label() }}</a>
                @endforeach
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($places as $place)
                    <x-explore-card :place="$place" />
                @empty
                    <p class="col-span-full text-ink-muted">Belum ada tempat yang cocok dengan pencarianmu.</p>
                @endforelse
            </div>
        @else
            <h2 class="mt-10 text-center text-2xl font-extrabold text-navy">{{ $heading }}</h2>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($places as $place)
                    <x-explore-card :place="$place" />
                @empty
                    <p class="col-span-full text-center text-ink-muted">Belum ada tempat terdaftar di sini.</p>
                @endforelse
            </div>
        @endif
    </div>
</x-layouts.app>
