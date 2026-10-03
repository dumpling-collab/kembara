<x-layouts.app title="Beranda">
    {{-- Hero --}}
    <section class="dot-pattern -mt-24 rounded-b-[80px] bg-white px-6 pb-20 pt-40 shadow-soft md:px-20">
        <div class="mx-auto grid max-w-[1310px] items-center gap-12 md:grid-cols-2">
            <div>
                <h1 class="text-5xl font-extrabold leading-tight tracking-tight md:text-6xl">
                    Berjelajah Jakarta <br> dengan <span class="text-brand">Kembara!</span>
                </h1>
                <p class="mt-6 max-w-md text-ink-muted">
                    Temukan sudut tersembunyi Jakarta, nikmati warisan budaya, dan jadikan setiap langkah
                    sebuah petualangan dengan panduan interaktif kami.
                </p>
                <a href="{{ route('trips.create') }}" class="btn-brand mt-8">Start Planning →</a>
            </div>
            <div class="relative h-[420px]">
                <img src="{{ asset('images/places/kota-tua.jpg') }}" alt="Kota Tua"
                     class="absolute right-0 top-0 h-64 w-72 rotate-3 rounded-[40px] object-cover shadow-soft">
                <img src="{{ asset('images/places/monas.jpg') }}" alt="Monas"
                     class="absolute bottom-0 left-8 h-64 w-72 -rotate-3 rounded-[40px] object-cover shadow-soft">
                <span class="absolute left-0 top-1/2 rounded-full bg-white px-4 py-2 text-sm font-bold shadow-soft">📍 100+ Spot Jakarta Terpilih</span>
            </div>
        </div>
    </section>

    {{-- Rekomendasi --}}
    <section class="bg-sky-soft px-6 py-28 md:px-20">
        <div class="mx-auto max-w-[1310px]">
            <h2 class="text-center text-4xl font-bold tracking-tight md:text-5xl">Rekomendasi Tempat Hits di Jakarta</h2>
            <p class="mt-3 text-center text-xl text-ink-muted">Kurasi tempat terbaik untuk petualanganmu hari ini.</p>

            <div class="mt-16 grid gap-8 md:grid-cols-3">
                @if ($topPick)
                    <a href="{{ route('places.index', ['q' => $topPick->name]) }}" class="glass-card md:col-span-2 md:row-span-2">
                        <div class="relative h-[420px]">
                            <img src="{{ asset($topPick->image) }}" alt="{{ $topPick->name }}" class="h-full w-full object-cover">
                            <span class="absolute left-6 top-6 rounded-full bg-white/90 px-4 py-2 text-sm font-bold">🔥 Top Pick</span>
                        </div>
                        <div class="flex items-center justify-between bg-white/50 p-8">
                            <div>
                                <h3 class="text-3xl font-bold">{{ $topPick->name }}</h3>
                                <p class="mt-2 text-lg text-ink-muted">{{ $topPick->tagline }} • {{ $topPick->district }}</p>
                            </div>
                            <span class="rounded-xl bg-sand px-4 py-2 text-lg font-bold text-black">⭐ {{ $topPick->rating }}</span>
                        </div>
                    </a>
                @endif

                @foreach ($others as $place)
                    <a href="{{ route('places.index', ['q' => $place->name]) }}" class="glass-card">
                        <img src="{{ asset($place->image) }}" alt="{{ $place->name }}" class="h-56 w-full object-cover">
                        <div class="bg-white/50 p-6">
                            <h3 class="text-2xl font-bold">{{ $place->name }}</h3>
                            <p class="mb-3 mt-1 text-ink-muted">{{ $place->tagline }}</p>
                            <span class="font-bold text-black">⭐ {{ $place->rating }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Bara --}}
    <section class="bg-navy px-6 py-28 text-white md:px-20">
        <div class="mx-auto grid max-w-[1310px] items-center gap-16 md:grid-cols-2">
            <div class="mx-auto flex h-80 w-80 items-center justify-center rounded-[40px] bg-white shadow-soft">
                <img src="{{ asset('images/brand/bara.png') }}" alt="Bara, maskot Kembara" class="h-60">
            </div>
            <div>
                <h2 class="text-4xl font-bold">Kenalan sama Bara, Teman Jelajahmu!</h2>
                <p class="mt-4 text-white/70">Bara, si burung layang-layang petualang, siap memandu perjalananmu menyusuri cerita tersembunyi di setiap sudut kota Jakarta.</p>
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5">
                        <h3 class="font-bold">Filosofi Kota</h3>
                        <p class="mt-1 text-sm text-white/70">Pahami makna di balik setiap monumen dan jalan bersejarah.</p>
                    </div>
                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5">
                        <h3 class="font-bold">Fakta Unik</h3>
                        <p class="mt-1 text-sm text-white/70">Temukan rahasia kecil Jakarta yang jarang diketahui orang.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tag kami --}}
    <section class="bg-sky-soft px-6 py-28 md:px-20">
        <div class="mx-auto max-w-[1310px]">
            <h2 class="text-5xl font-extrabold leading-tight">Tag Kami <br> Pada Perjalananmu!</h2>
            <p class="mt-3 text-ink-muted">#bersamaKembara #kelilingJKTdgnKembara #TripdgnKembara</p>
        </div>
    </section>
</x-layouts.app>
