@php
    $modes = [
        'umum' => ['label' => 'Transportasi Umum', 'icon' => '🚌'],
        'motor' => ['label' => 'Motor', 'icon' => '🏍️'],
        'mobil' => ['label' => 'Mobil', 'icon' => '🚗'],
    ];

    $cheapestMode = collect($modes)->keys()->sortBy(fn ($m) => match ($m) {
        'umum' => 0, 'motor' => 1, default => 2,
    })->first();
@endphp

<x-layouts.app title="Estimasi & Transportasi" :bare="true">
    <div class="mx-auto max-w-[1200px] px-6 py-10">
        <a href="{{ route('trips.route', $trip) }}" class="text-sm font-bold text-navy">← Kembali ke Pilih Destinasi</a>

        <h1 class="mt-3 text-2xl font-extrabold text-navy sm:text-3xl">Estimasi Perjalanan &amp; Pilihan Transportasi</h1>
        <p class="mt-2 max-w-xl text-sm text-ink-muted">
            Pilih moda transportasi untuk melihat estimasi waktu, rute terbaik, dan rincian biaya perjalananmu.
        </p>

        @if ($mode !== 'umum')
            <p class="mt-3 inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold
                {{ $result['used_real_routing'] ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                {{ $result['used_real_routing'] ? '✓ Memakai rute jalan sungguhan (OpenRouteService)' : '⚠ Memakai estimasi jarak garis lurus — cek API key OpenRouteService' }}
            </p>
        @else
            <p class="mt-3 inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700">
                ⚠ Transportasi umum selalu pakai estimasi (belum ada data rute transit sungguhan)
            </p>
        @endif

        <div class="mt-4 flex rounded-2xl bg-slate-200/60 p-1.5">
            @foreach ($modes as $key => $m)
                <a href="{{ route('trips.transport', [$trip, 'mode' => $key]) }}"
                   class="relative flex flex-1 items-center justify-center gap-2 rounded-xl py-3 text-sm font-bold transition
                   {{ $mode === $key ? 'bg-navy text-white shadow-soft' : 'text-ink-muted' }}">
                    <span>{{ $m['icon'] }}</span> {{ $m['label'] }}
                    @if ($key === $cheapestMode)
                        <span class="absolute -top-2 right-2 rounded-full bg-blue-100 px-2 py-0.5 text-[9px] font-bold text-blue-700">Paling Hemat</span>
                    @elseif ($key === 'mobil')
                        <span class="absolute -top-2 right-2 rounded-full bg-blue-100 px-2 py-0.5 text-[9px] font-bold text-blue-700">Paling Nyaman</span>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="rounded-3xl bg-surface p-6 shadow-soft">
                <ol class="space-y-6 border-l-2 border-slate-200 pl-6">
                    @foreach ($result['legs'] as $leg)
                        <li class="relative">
                            <span class="absolute -left-[29px] top-1 h-3 w-3 rounded-full bg-navy"></span>
                            <p class="text-xs font-bold text-navy">{{ $leg['time'] }}</p>
                            <p class="text-lg font-bold">{{ $leg['title'] }}</p>
                            <p class="text-sm text-ink-muted">{{ $leg['subtitle'] }}</p>

                            @if ($leg['travel'])
                                <div class="mt-2 rounded-xl bg-white p-3 text-sm shadow-soft">
                                    <p class="flex items-start gap-2">
                                        <span>🛣️</span>
                                        <span>{{ $leg['travel']['description'] }}</span>
                                    </p>
                                    <p class="mt-1 pl-6 text-xs text-ink-muted">
                                        Estimasi {{ $leg['travel']['duration_min'] }} mnt
                                        • {{ implode(' • ', $leg['travel']['breakdown']) }}
                                    </p>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl bg-surface p-6 shadow-soft">
                    <h2 class="text-lg font-bold text-navy">Rincian Biaya Transportasi</h2>

                    <div class="mt-4 flex justify-between text-sm">
                        <span class="text-ink-muted">Subtotal Transportasi</span>
                        <span class="font-bold">Rp {{ number_format($result['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 flex justify-between border-b border-slate-200 pb-4 text-sm">
                        <span class="text-ink-muted">Parkir / Tol</span>
                        <span class="font-bold">Rp {{ number_format($result['extra'], 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-4 rounded-2xl bg-navy p-5 text-center text-white">
                        <p class="text-xs text-white/70">Estimasi Total</p>
                        <p class="text-3xl font-extrabold text-brand">Rp {{ number_format($result['total'], 0, ',', '.') }}</p>
                    </div>

                    <form method="POST" action="{{ route('love-board.save', $trip) }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="mode" value="{{ $mode }}">
                        <button type="submit" class="btn-brand w-full">
                            {{ $trip->saved_to_love_board_at ? '✓ Tersimpan — Update ke Love Board' : 'Simpan ke Love Board ❤️' }}
                        </button>
                    </form>
                    @if ($trip->saved_to_love_board_at)
                        <p class="mt-2 text-center text-xs text-ink-muted">
                            Tersimpan di <a href="{{ route('love-board.index') }}" class="font-bold text-navy underline">Love Board</a>
                        </p>
                    @endif
                </div>

                <div class="flex items-start gap-3 rounded-3xl bg-orange-50 p-5">
                    <img src="{{ asset('images/brand/bara-wave.png') }}" alt="Bara" class="h-12 w-12 flex-shrink-0 object-contain">
                    <div>
                        <p class="font-bold text-navy">Tips dari Bara!</p>
                        <p class="mt-1 text-sm text-ink-muted">
                            @if ($mode === 'mobil')
                                Perhatikan aturan ganjil-genap di jalan-jalan protokol ya, cek dulu sebelum berangkat!
                            @elseif ($mode === 'motor')
                                Naik motor paling lincah buat selap-selip, tapi pastikan bawa jas hujan ya!
                            @else
                                Kalau naik MRT & TransJakarta, cek dulu jam operasionalnya biar nggak ketinggalan!
                            @endif
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>
