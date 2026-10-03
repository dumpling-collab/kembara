@php
    $reviews = $place->reviews_count >= 1000
        ? number_format($place->reviews_count / 1000, 1, ',', '.') . 'k'
        : $place->reviews_count;

    $backUrl = request()->filled('back') ? urldecode(request('back')) : route('places.index');
    $backLabel = str_contains($backUrl, '/trips/') ? '← Kembali ke Pilih Destinasi' : '← Kembali ke Pencarian';
@endphp

<x-layouts.app :title="$place->name" :bare="true">
    <div class="mx-auto max-w-[1200px] px-6 py-8">
        <a href="{{ $backUrl }}"
           class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm shadow-soft">
            {{ $backLabel }}
        </a>

        <div class="mt-6 grid gap-8 lg:grid-cols-[1.45fr_1fr]">
            <div class="space-y-6">
                @if ($place->image)
                    <img src="{{ asset($place->image) }}" alt="{{ $place->name }}"
                         class="h-64 w-full rounded-[28px] object-cover shadow-soft sm:h-80">
                @endif

                <section class="rounded-[28px] bg-surface p-8 shadow-soft">
                    <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-bold tracking-wide text-emerald-800">
                        {{ $place->badge ?? $place->category->label() }}
                    </span>

                    <h1 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $place->name }}</h1>

                    <p class="mt-3 flex flex-wrap items-center gap-x-3 text-sm text-ink-muted">
                        <span><span class="text-brand">☆</span> {{ $place->rating }}</span>
                        @if ($place->reviews_count)
                            <span>• ({{ $reviews }} ulasan)</span>
                        @endif
                        <span>• 📍 {{ $place->address ?? $place->district }}</span>
                    </p>

                    @if ($place->opening_hours || $place->ticket_price || $place->access_info)
                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            @foreach ([
                                ['🕒', 'Jam Buka', $place->opening_hours],
                                ['🎟️', 'Tiket Masuk', $place->ticket_price],
                                ['🚆', 'Akses', $place->access_info],
                            ] as [$icon, $label, $value])
                                @if ($value)
                                    <div class="rounded-2xl bg-white p-4 shadow-soft">
                                        <div class="text-lg">{{ $icon }}</div>
                                        <p class="mt-1 text-[11px] text-ink-muted">{{ $label }}</p>
                                        <p class="font-bold">{{ $value }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if ($place->description)
                        <h2 class="mt-8 text-xl font-bold">Tentang Tempat Ini</h2>
                        <p class="mt-3 max-w-xl leading-relaxed text-ink-muted">{{ $place->description }}</p>
                    @endif
                </section>
            </div>

            <aside class="space-y-6 lg:pt-8">
                @if ($place->bara_story || $place->bara_tip)
                    <section class="rounded-[28px] bg-surface p-8 shadow-soft">
                        <h2 class="flex items-center gap-2 text-xl font-bold text-brand">
                            <span>📍</span> Cerita &amp; Tip Spesial dari Bara
                        </h2>

                        <div class="mt-5 rounded-2xl bg-white p-5 shadow-soft">
                            @if ($place->bara_story)
                                <p class="italic leading-relaxed text-ink-muted">"{{ $place->bara_story }}"</p>
                            @endif

                            @if ($place->bara_tip)
                                <div class="mt-4 rounded-xl border border-mint/30 bg-mint/10 p-4 text-sm">
                                    <p class="font-bold text-mint">✔ Tip Rahasia:</p>
                                    <p class="mt-1 leading-relaxed text-ink-muted">{{ $place->bara_tip }}</p>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif

                {{-- Rekomendasi UMKM --}}
                @if ($place->umkmRecommendations->isNotEmpty())
                    <section class="rounded-[28px] bg-surface p-6 shadow-soft">
                        <h2 class="flex items-center gap-2 font-bold text-navy">
                            <span>🛍️</span> Rekomendasi UMKM
                        </h2>

                        <ul class="mt-4 space-y-3">
                            @foreach ($place->umkmRecommendations as $u)
                                <li class="rounded-xl bg-white p-3 shadow-soft">
                                    <p class="text-sm font-bold">{{ $u->name }}</p>
                                    @if ($u->description)
                                        <p class="mt-0.5 text-xs leading-snug text-ink-muted">{{ $u->description }}</p>
                                    @endif
                                    @if ($u->opening_hours)
                                        <p class="mt-1 text-[11px] text-ink-muted">🕒 {{ $u->opening_hours }} WIB</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                <section class="rounded-[28px] bg-surface p-8 shadow-soft">
                    @guest
                        <h2 class="text-xl font-bold">Masuk untuk menyusun itinerary</h2>
                        <div class="mt-6 text-right">
                            <a href="{{ route('login') }}" class="btn-brand">Login/Sign up</a>
                        </div>
                    @else
                        <h2 class="text-xl font-bold">
                            {{ $inTrip ? 'Sudah ada di itinerary' : 'Belum ditambahkan ke itinerary' }}
                        </h2>
                        @if ($trip)
                            <p class="mt-1 text-sm text-ink-muted">Trip: {{ $trip->name }}</p>
                        @endif

                        <div class="mt-6 text-right">
                            @if ($trip)
                                <form method="POST" action="{{ route('trips.places.toggle', [$trip, $place]) }}">
                                    @csrf
                                    <button class="{{ $inTrip ? 'btn-navy' : 'btn-brand' }}">
                                        {{ $inTrip ? '✓ Ditambahkan ke Trip' : '+ Tambahkan ke Trip' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('trips.create') }}" class="btn-brand">+ Buat Trip Dulu</a>
                            @endif
                        </div>
                    @endguest
                </section>
            </aside>
        </div>
    </div>
</x-layouts.app>
