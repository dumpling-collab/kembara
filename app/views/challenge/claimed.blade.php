<x-layouts.app title="Rewards Claimed" :bare="true">
    <div class="dot-pattern flex min-h-screen items-center justify-center px-6 text-center">
        <div>
            <div class="flex items-center justify-center gap-3">
                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-navy text-sm font-bold text-brand">kembara</span>
                <span class="text-2xl font-extrabold text-brand">+1</span>
                <span class="text-2xl font-extrabold text-brand">+{{ $challenge->point_reward }} Credits</span>
            </div>

            <h1 class="mt-6 text-4xl font-extrabold text-brand sm:text-5xl">Rewards Claimed!</h1>
            <p class="mt-2 text-ink-muted">{{ $challenge->title }}</p>

            <a href="{{ route('challenge.index') }}" class="btn-brand mt-8 inline-flex">Kembali ke Challenge</a>
        </div>
    </div>
</x-layouts.app>
