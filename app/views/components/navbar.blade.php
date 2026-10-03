@php
    $links = [
        ['Explore', route('places.index'), request()->routeIs('places.*')],
        ['Challenge', route('challenge.index'), request()->routeIs('challenge.*')],
        ['Local Partners', '#', false],
        ['Love Board', route('love-board.index'), request()->routeIs('love-board.*')],
    ];
@endphp

<header class="sticky top-4 z-50 mx-auto mt-4 max-w-[1367px] px-4">
    <div class="flex items-center justify-between rounded-full border border-white/40 bg-surface/70 px-8 py-3 shadow-soft backdrop-blur-xl">
        <a href="{{ route('home') }}" aria-label="Kembara">
            <img src="{{ asset('images/brand/logo.png') }}" alt="Kembara" class="h-10 w-auto">
        </a>

        <nav class="hidden gap-8 md:flex">
            @foreach ($links as [$label, $href, $active])
                <a href="{{ $href }}"
                   class="pb-0.5 text-base {{ $active ? 'border-b-2 border-brand font-bold text-navy' : 'text-ink-muted hover:text-navy' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        @auth
            <details class="relative">
                <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full bg-brand py-1.5 pl-1.5 pr-5 text-sm font-bold text-white [&::-webkit-details-marker]:hidden">
                    <img src="{{ asset('images/brand/bara-wave.png') }}" alt=""
                         class="h-8 w-8 rounded-full bg-white object-contain p-1">
                    {{ Str::limit(auth()->user()->username ?? auth()->user()->name, 14) }}
                </summary>

                <div class="absolute right-0 mt-3 w-56 rounded-2xl bg-white p-2 shadow-soft">
                    <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-2 text-sm hover:bg-sky-soft">Akun Saya</a>
                    <a href="{{ route('trips.create') }}" class="block rounded-xl px-4 py-2 text-sm hover:bg-sky-soft">Rencanakan Perjalanan</a>
                    <a href="{{ route('challenge.index') }}" class="block rounded-xl px-4 py-2 text-sm hover:bg-sky-soft">Challenge</a>
                    <a href="{{ route('love-board.index') }}" class="block rounded-xl px-4 py-2 text-sm hover:bg-sky-soft">Love Board</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full rounded-xl px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                </div>
            </details>
        @else
            <a href="{{ route('login') }}" class="btn-brand !py-2.5">Login/Sign up</a>
        @endauth
    </div>
</header>
