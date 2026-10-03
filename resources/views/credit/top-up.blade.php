<x-layouts.app title="Top Up Credits">
    <div class="mx-auto max-w-3xl px-6 py-10">
        <a href="{{ route('challenge.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-bold text-navy shadow-soft">
            ← Kembali ke Tantangan
        </a>

        <h1 class="mt-6 text-4xl font-extrabold text-navy sm:text-5xl">Top Up Credits</h1>
        <p class="mt-2 text-ink-muted">kamu bisa top up Credits juga selain mengerjakan quest kami!</p>

        <div class="mt-8 divide-y divide-slate-100 rounded-3xl bg-surface p-6 shadow-soft">
            <div class="grid grid-cols-[1fr_auto_auto] items-center gap-4 pb-4 text-sm font-bold text-navy">
                <span>Credits</span>
                <span></span>
                <span class="text-right">Harga</span>
            </div>

            @foreach ($packages as $amount => $info)
                <div class="grid grid-cols-[1fr_auto_auto] items-center gap-4 py-5">
                    <span class="text-2xl font-extrabold text-navy">{{ $amount }} Credits</span>

                    <span class="rounded-full bg-navy px-4 py-1.5 text-xs font-bold text-white">{{ $info['badge'] }}</span>

                    <form method="POST" action="{{ route('credit.purchase', $amount) }}">
                        @csrf
                        <button class="btn-brand !px-6">Rp {{ number_format($info['price'], 0, ',', '.') }}</button>
                    </form>
                </div>
            @endforeach
        </div>

        <p class="mt-4 text-center text-xs text-ink-muted">
            * Top up ini masih simulasi — credit langsung masuk tanpa proses pembayaran sungguhan.
        </p>
    </div>
</x-layouts.app>
