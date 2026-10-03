<x-layouts.app title="Challenge">
    {{-- Hero --}}
    <section class="dot-pattern bg-white px-6 pb-16 pt-10 md:px-20">
        <div class="mx-auto max-w-[1310px]">
            <a href="{{ route('home') }}" class="text-navy">←</a>

            @if (session('status'))
                <p class="mt-4 inline-block rounded-xl bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">{{ session('status') }}</p>
            @endif

            <div class="mt-4 grid items-center gap-10 md:grid-cols-2">
                <div>
                    <h1 class="text-4xl font-extrabold leading-tight sm:text-5xl">
                        Tantangan Jelajah <br> dengan <span class="text-brand">Kembara!</span>
                    </h1>
                    <p class="mt-4 max-w-md text-ink-muted">
                        Selesaikan tantangan di berbagai sudut Jakarta, klaim stempel digital
                        di paspormu, dan kumpulkan Kembara Credits!
                    </p>
                </div>

                <div>
                    <div class="rounded-3xl bg-surface p-8 shadow-soft">
                        <div class="flex items-center justify-between">
                            <p class="font-bold">Passport: <span class="text-emerald-600">Activated</span></p>
                            <x-kembara-badge size="sm" />
                        </div>
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-ink-muted">Stamps Achieved</p>
                                <p class="text-2xl font-extrabold text-navy">{{ $stampsAchieved }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-ink-muted">Credit Points</p>
                                <p class="text-2xl font-extrabold text-brand">{{ $creditPoints }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('challenge.passport') }}" class="btn-brand flex-1 justify-center">Koleksi Stamps Anda →</a>
                        <a href="{{ route('credit.top-up') }}" class="btn-navy flex-1 justify-center">Top Up Credit →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Daftar challenge --}}
    <section class="bg-sky-soft px-6 py-16 md:px-20">
        <div class="mx-auto grid max-w-[1310px] gap-8 lg:grid-cols-[1fr_300px]">
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($challenges as $c)
                    <article class="overflow-hidden rounded-3xl bg-surface shadow-soft">
                        <div class="relative h-36">
                            @if ($c->image)
                                <img src="{{ asset($c->image) }}" alt="{{ $c->title }}" class="h-full w-full object-cover">
                            @endif
                            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold">📍 {{ $c->district }}</span>
                        </div>
                        <div class="space-y-3 p-5">
                            <h3 class="font-bold">{{ $c->title }}</h3>
                            <div class="flex gap-2">
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700">+1 Stamp</span>
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700">+{{ $c->point_reward }} PTS</span>
                            </div>

                            @if ($c->is_completed)
                                <span class="block rounded-full bg-emerald-100 py-2.5 text-center text-sm font-bold text-emerald-700">✓ Selesai</span>
                            @else
                                <a href="{{ route('challenge.show', $c) }}"
                                   class="block w-full rounded-full border border-navy py-2.5 text-center text-sm font-bold text-navy transition hover:bg-navy hover:text-white">
                                    {{ $c->verified_count > 0 ? "Lanjutkan ({$c->verified_count}/{$c->checkpoints_count})" : 'Ikuti Challenge' }}
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="h-fit rounded-3xl bg-surface p-6 shadow-soft">
                <h2 class="font-bold">Tips Bara</h2>
                <div class="mt-4 flex items-start gap-3">
                    <img src="{{ asset('images/brand/bara-map.png') }}" alt="Bara" class="h-16 w-16 flex-shrink-0 object-contain">
                    <p class="rounded-xl bg-navy px-3 py-2 text-xs italic text-white">
                        "Kumpulkan Points sebanyak-banyaknya untuk ditukar!"
                    </p>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
