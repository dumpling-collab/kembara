<x-layouts.app title="Local Partners">
    {{-- Hero --}}
    <section class="dot-pattern rounded-b-[60px] bg-white px-6 py-20 text-center shadow-soft md:px-20">
        <div class="mx-auto max-w-2xl">
            <h1 class="text-3xl font-extrabold leading-tight sm:text-4xl">
                Tumbuh Bersama <span class="text-brand">Kembara Local Partners</span>
            </h1>
            <p class="mt-4 text-ink-muted">
                Bantu UMKM lokal Jakarta makin dikenal wisatawan. Promosikan tempat makan
                atau usahamu lewat sistem Challenge & Rekomendasi Kembara!
            </p>
            <a href="{{ route('local-partners.form') }}" class="btn-brand mt-8 inline-flex">Ajukan Kerja Sama Sekarang →</a>
        </div>
    </section>

    {{-- Keuntungan --}}
    <section class="bg-sky-soft px-6 py-16 md:px-20">
        <div class="mx-auto max-w-275">
            <h2 class="text-center text-3xl font-extrabold text-navy">Keuntungan Menjadi Mitra</h2>

            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                @foreach ([
                    ['📢', 'Promosi via Challenge', 'Usahamu muncul langsung sebagai misi di fitur Challenge & Stamp Kembara.'],
                    ['🧭', 'Jangkauan Wisatawan', 'Didatangi langsung oleh penjelajah & wisatawan lokal Jakarta.'],
                    ['✅', 'Dukungan Kualitas', 'Pendampingan standar kualitas produk dan pelayanan dari tim Kembara.'],
                ] as [$icon, $title, $desc])
                    <div class="rounded-3xl bg-surface p-6 shadow-soft">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-xl">{{ $icon }}</span>
                        <h3 class="mt-5 font-bold text-navy">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-ink-muted">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Syarat & Kriteria --}}
            <div class="mt-12 rounded-3xl bg-surface p-8 shadow-soft sm:p-10">
                <h2 class="text-center text-2xl font-extrabold text-navy">Syarat &amp; Kriteria Mitra UMKM</h2>

                <ul class="mx-auto mt-8 max-w-xl space-y-5">
                    @foreach ([
                        ['Profit / Bulan', 'Rata-rata < Rp1 - 2 Juta (Prioritas pemberdayaan UMKM berkembang).'],
                        ['Aksesibilitas', 'Lokasi mudah diakses oleh pengunjung/wisatawan.'],
                        ['Standarisasi Kualitas', 'Menjaga standar kualitas produk serta pelayanan yang baik.'],
                    ] as [$title, $desc])
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-xs text-white">✓</span>
                            <div>
                                <p class="font-bold text-navy">{{ $title }}</p>
                                <p class="text-sm text-ink-muted">{{ $desc }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- CTA bawah --}}
            <div class="mt-12 rounded-3xl bg-white p-10 text-center shadow-soft">
                <h2 class="text-2xl font-extrabold text-navy">Siap Mengembangkan Usahamu?</h2>
                <a href="{{ route('local-partners.form') }}" class="btn-brand mt-6 inline-flex">Mulai Pengisian Form →</a>
            </div>
        </div>
    </section>
</x-layouts.app>
