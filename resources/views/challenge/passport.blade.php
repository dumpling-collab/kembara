<x-layouts.app title="Digital Passport">
    <div class="mx-auto max-w-[1310px] px-6 py-10">
        <a href="{{ route('challenge.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-bold text-navy shadow-soft">
            ← Kembali ke Tantangan
        </a>

        <h1 class="mt-6 text-4xl font-extrabold leading-tight text-navy sm:text-5xl">Jakarta Digital Passport</h1>
        <p class="mt-2 text-ink-muted">Liat koleksi stempelmu disini!</p>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($challenges as $c)
                <article class="overflow-hidden rounded-3xl bg-surface shadow-soft">
                    @if ($c->image)
                        <img src="{{ asset($c->image) }}" alt="{{ $c->title }}" class="h-36 w-full object-cover">
                    @endif
                    <div class="space-y-3 p-5">
                        <h3 class="text-lg font-bold">{{ $c->district }}</h3>
                        <p>
                            <span class="text-2xl font-extrabold {{ $c->is_completed ? 'text-brand' : 'text-slate-300' }}">
                                {{ $c->is_completed ? 1 : 0 }}
                            </span>
                            <span class="text-sm text-ink-muted">/20</span>
                        </p>
                        <a href="{{ route('challenge.index') }}" class="block rounded-full border border-navy py-2 text-center text-sm font-bold text-navy">
                            Liat Stampel
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-layouts.app>
