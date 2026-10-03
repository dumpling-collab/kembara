<x-layouts.app title="Rewards Claimed">
    <div class="dot-pattern flex min-h-[70vh] items-center justify-center px-6 text-center">
        <div>
            <div class="flex items-center justify-center gap-3">
                <x-kembara-badge size="sm" />
                <span class="text-2xl font-extrabold text-brand">+1</span>
                <span class="text-2xl font-extrabold text-brand">+{{ $challenge->point_reward }} Credits</span>
            </div>

            <h1 class="mt-6 text-4xl font-extrabold text-brand sm:text-5xl">Rewards Claimed!</h1>
            <p class="mt-2 text-ink-muted">{{ $challenge->title }}</p>

            <a href="{{ route('challenge.index') }}" class="btn-brand mt-8 inline-flex">Kembali ke Challenge</a>
        </div>
    </div>
</x-layouts.app>
