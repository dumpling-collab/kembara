@php
    $firstPlace = $trip->places->first();
@endphp

<x-layouts.app title="Titik Awal" :bare="true">
    <div class="mx-auto max-w-[1200px] px-6 py-10">
        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
            {{-- Kolom kiri --}}
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('trips.places', $trip) }}" class="text-navy">←</a>
                    <h1 class="text-2xl font-extrabold text-navy sm:text-3xl">Dari Mana Kamu Akan Berangkat?</h1>
                </div>
                <p class="mt-2 max-w-xl text-sm text-ink-muted">
                    Pilih titik keberangkatan dan atur urutan tempat yang ingin kamu kunjungi
                    agar rute perjalananmu lebih efisien.
                </p>

                <form method="POST" action="{{ route('trips.route.store', $trip) }}" id="starting-point-form">
                    @csrf
                    <input type="hidden" name="starting_point_lat" id="starting_point_lat">
                    <input type="hidden" name="starting_point_lng" id="starting_point_lng">
                    <input type="hidden" name="order" id="order-input">

                    {{-- Input titik keberangkatan --}}
                    <div class="mt-6 rounded-3xl bg-surface p-6 shadow-soft">
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <input type="text" name="starting_point_name" id="starting_point_name"
                                   value="{{ old('starting_point_name', $trip->starting_point_name) }}"
                                   class="field flex-1" placeholder="Cari titik awal keberangkatan" required
                                   autocomplete="off">
                            <button type="button" id="use-gps"
                                    class="whitespace-nowrap rounded-full bg-orange-100 px-5 py-3 text-sm font-bold text-brand">
                                📍 Gunakan Lokasi Saat Ini (GPS)
                            </button>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <button type="button" class="quick-point rounded-full bg-white px-3 py-1.5 text-xs font-bold shadow-soft" data-name="Lokasi Saya Saat Ini">
                                🏠 Lokasi Saya Saat Ini
                            </button>
                            @foreach ($quickPoints as $point)
                                <button type="button" class="quick-point rounded-full bg-white px-3 py-1.5 text-xs font-bold shadow-soft" data-name="{{ $point }}">
                                    {{ $point }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Daftar destinasi: drag untuk urutkan --}}
                    <div class="mt-6 rounded-3xl bg-surface p-6 shadow-soft">
                        <p class="text-sm">
                            <span class="font-bold">Titik Keberangkatan:</span>
                            <span id="origin-label">{{ $trip->starting_point_name ?: '—' }}</span>
                        </p>

                        <ul id="sortable-list" class="mt-4 space-y-3 border-l-2 border-dashed border-slate-200 pl-4">
                            @foreach ($trip->places as $i => $place)
                                <li draggable="true" data-id="{{ $place->id }}"
                                    class="flex items-center gap-3 rounded-2xl bg-white p-4 shadow-soft">
                                    <span class="cursor-grab text-slate-300">⠿</span>
                                    <div class="flex-1">
                                        <p class="font-bold">{{ $i + 1 }}. {{ $place->name }}</p>
                                        <p class="mt-1 flex items-center gap-2 text-xs text-ink-muted">
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 font-bold">{{ $place->category->label() }}</span>
                                            @if ($place->visit_duration_min)
                                                🕒 {{ $place->visit_duration_min }}–{{ $place->visit_duration_max }} menit
                                            @endif
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('trips.places.toggle', [$trip, $place]) }}">
                                        @csrf
                                        <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100 text-red-500">✕</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>

            {{-- Sidebar Ringkasan --}}
            <aside class="h-fit rounded-3xl bg-surface p-6 shadow-soft lg:sticky lg:top-6">
                <h2 class="text-xl font-bold text-navy">Ringkasan</h2>
                <div class="mt-3 flex items-center gap-3 text-sm">
                    <span>{{ $trip->places->count() }} Tempat Dipilih</span>
                    @if ($roughDuration)
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold">{{ $roughDuration }}</span>
                    @endif
                </div>

                <div class="relative mt-6 flex items-start gap-3 rounded-2xl bg-white p-4 shadow-soft">
                    <img src="{{ asset('images/brand/bara-map.png') }}" alt="Bara" class="h-16 w-16 flex-shrink-0 object-contain">
                    <p class="rounded-xl bg-navy px-3 py-2 text-xs italic leading-snug text-white">
                        "Bara sudah menyusun rute terbaik
                        @if ($trip->starting_point_name) dari {{ $trip->starting_point_name }} @endif
                        @if ($firstPlace) ke {{ $firstPlace->name }} @endif
                        tanpa putar balik!"
                    </p>
                </div>

                <button type="submit" form="starting-point-form"
                        class="btn-navy mt-6 block w-full text-center">
                    Lanjut ke Estimasi &amp; Transportation Mode →
                </button>
            </aside>
        </div>
    </div>

    <script>
        // Pilih titik keberangkatan cepat
        document.querySelectorAll('.quick-point').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('starting_point_name').value = btn.dataset.name;
                document.getElementById('origin-label').textContent = btn.dataset.name;
            });
        });

        // Gunakan GPS browser
        document.getElementById('use-gps').addEventListener('click', () => {
            if (! navigator.geolocation) {
                alert('Browser ini tidak mendukung GPS.');
                return;
            }
            navigator.geolocation.getCurrentPosition((pos) => {
                document.getElementById('starting_point_name').value = 'Lokasi Saya Saat Ini';
                document.getElementById('origin-label').textContent = 'Lokasi Saya Saat Ini';
                document.getElementById('starting_point_lat').value = pos.coords.latitude;
                document.getElementById('starting_point_lng').value = pos.coords.longitude;
            }, () => {
                alert('Gagal mengambil lokasi. Coba pakai titik awal manual.');
            });
        });

        // Drag-and-drop urutan destinasi (native HTML5, tanpa library tambahan)
        const list = document.getElementById('sortable-list');
        let dragging = null;

        list.querySelectorAll('li').forEach(item => {
            item.addEventListener('dragstart', () => { dragging = item; item.classList.add('opacity-50'); });
            item.addEventListener('dragend', () => { dragging.classList.remove('opacity-50'); dragging = null; syncOrder(); });
            item.addEventListener('dragover', (e) => {
                e.preventDefault();
                const after = getAfterElement(list, e.clientY);
                if (after == null) {
                    list.appendChild(dragging);
                } else {
                    list.insertBefore(dragging, after);
                }
            });
        });

        function getAfterElement(container, y) {
            const items = [...container.querySelectorAll('li:not(.opacity-50)')];
            return items.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                return (offset < 0 && offset > closest.offset) ? { offset, element: child } : closest;
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        function syncOrder() {
            const ids = [...list.querySelectorAll('li')].map(li => li.dataset.id);
            document.getElementById('order-input').value = ids.join(',');
        }
        syncOrder();
    </script>
</x-layouts.app>
