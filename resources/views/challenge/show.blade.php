<x-layouts.app :title="$challenge->title">
    <div class="mx-auto max-w-[1100px] px-6 py-8">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('challenge.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 font-bold text-navy shadow-soft">
                    ← Kembali ke Tantangan
                </a>
                <span class="text-ink-muted">Tantangan / <span class="font-bold text-navy">{{ $challenge->title }}</span></span>
            </div>

            <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700">
                Hadiah: 🏅 1x Stamp | {{ $challenge->point_reward }} Credits
            </span>
        </div>

        <div class="relative mt-6 overflow-hidden rounded-[28px]">
            @if ($challenge->image)
                <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->title }}" class="h-72 w-full object-cover">
            @endif
            <div class="absolute inset-0 bg-navy/70"></div>
            <div class="absolute inset-0 flex flex-col justify-center p-10 text-white">
                <h1 class="text-3xl font-extrabold sm:text-4xl">Tantangan: {{ $challenge->title }}</h1>
                <p class="mt-3 max-w-xl text-white/80">
                    Eksplorasi {{ $totalCount }} spot di kawasan {{ $challenge->district }} untuk melengkapi stempel pasportmu!
                </p>

                <p class="mt-6 text-xs font-bold uppercase tracking-wider text-white/70">Kemajuan Misi</p>
                <p class="text-sm font-bold">{{ $verifiedCount }}/{{ $totalCount }} Spot Terverifikasi</p>
                <div class="mt-2 h-2 w-full max-w-md rounded-full bg-white/20">
                    <div class="h-full rounded-full bg-brand" style="width: {{ $totalCount ? ($verifiedCount / $totalCount * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="mt-6 space-y-4">
            @foreach ($checkpoints as $i => $cp)
                <div class="flex flex-col gap-4 rounded-3xl bg-surface p-5 shadow-soft sm:flex-row sm:items-center">
                    @if ($cp->image)
                        <img src="{{ asset($cp->image) }}" alt="{{ $cp->name }}" class="h-20 w-full flex-shrink-0 rounded-xl object-cover sm:w-28">
                    @endif

                    <div class="flex-1">
                        <h3 class="font-bold">{{ $i + 1 }}. {{ $cp->name }}</h3>
                        @if ($cp->description)
                            <p class="mt-1 text-sm text-ink-muted">{{ $cp->description }}</p>
                        @endif
                        @if ($cp->tags)
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($cp->tags as $tag)
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-ink-muted">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if ($cp->is_verified)
                        <span class="flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700">
                            ✓ Terverifikasi
                        </span>
                    @else
                        <form method="POST" action="{{ route('challenge.checkpoint.verify', $cp) }}">
                            @csrf
                            <button class="rounded-full border border-navy px-4 py-2 text-sm font-bold text-navy">
                                Tandai Terkunjungi
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-right">
            @if ($isCompleted)
                <span class="inline-block rounded-full bg-emerald-100 px-8 py-3 font-bold text-emerald-700">✓ Sudah Diklaim</span>
            @else
                <form method="POST" action="{{ route('challenge.claim', $challenge) }}">
                    @csrf
                    <button type="submit" {{ $allVerified ? '' : 'disabled' }}
                            class="{{ $allVerified ? 'btn-brand' : 'cursor-not-allowed rounded-full bg-slate-200 px-8 py-3 font-bold text-slate-400' }}">
                        Klaim Stampel & Credits
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.app>
